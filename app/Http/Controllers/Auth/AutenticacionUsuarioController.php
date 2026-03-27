<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\IniciarSesionRequest;

use App\Models\DatoUsuarioAutenticado;
use App\Models\Actividad;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AutenticacionUsuarioController extends Controller implements HasMiddleware
{
    private $datosUsuariosAutenticados;
    private $actividades;

    public function __construct()
    {
        $this->middleware();
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
        $this->actividades = new Actividad;
    }
    
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth', except: ['indice', 'autenticar']),
            new Middleware(middleware: 'guest', only: ['indice', 'autenticar']),
        ];
    }

    public function indice()
    {
        return view('auth.iniciar-sesion');
    }

    public function autenticar(IniciarSesionRequest $request)
    {
        $usuario = $request->validated('usuario');
        $clave = $request->validated('clave');

        $verificarUsuario = $this->datosUsuariosAutenticados->verificarUsuario($usuario);
        if ((!$verificarUsuario)) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Autenticación',
                $accion = 5,
                $resultado = 3,
                $descripcion = 'Se intentó iniciar sesión con un usuario no registrado: '.$usuario,
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'usuario' => 'Acceso denegado, usuario NO registrado.',
            ])->onlyInput('usuario');
        }

        $verificarIntentosFallidos = $this->datosUsuariosAutenticados->verificarIntentosFallidosUsuario($usuario);
        if ((!$verificarIntentosFallidos)) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Autenticación',
                $accion = 5,
                $resultado = 3,
                $descripcion = 'Se intentó iniciar sesión con un usuario bloqueado por demasiados intentos fallidos: '.$usuario,
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'usuario' => 'Acceso denegado, usuario bloqueado por demasiados intentos fallidos.',
            ])->onlyInput('usuario');
        }

        $verificarClave = $this->datosUsuariosAutenticados->verificarClavePorUsuario($usuario, $clave);
        if ((!$verificarClave)) {
            $this->datosUsuariosAutenticados->registrarIntentosFallidosUsuario($usuario);
            $verificarIntentosFallidos = $this->datosUsuariosAutenticados->verificarIntentosFallidosUsuario($usuario);
            if ((!$verificarIntentosFallidos)) {
                $this->actividades->registrarActividad(
                    $usuarioId = null,
                    $modulo = 'Autenticación',
                    $accion = 5,
                    $resultado = 3,
                    $descripcion = 'Se intentó iniciar sesión con un usuario bloqueado por demasiados intentos fallidos: '.$usuario,
                    $request->ip(),
                    $request->header('User-Agent')
                );
                return back()->withErrors([
                    'usuario' => 'Acceso denegado, usuario bloqueado por demasiados intentos fallidos.',
                ])->onlyInput('usuario');
            }
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Autenticación',
                $accion = 5,
                $resultado = 3,
                $descripcion = 'Contraseña incorrecta para el usuario: '.$usuario,
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'usuario' => 'Acceso denegado, contraseña incorrecta.',
            ])->onlyInput('usuario');
        }

        $verificarEstado = $this->datosUsuariosAutenticados->verificarEstadoPorUsuario($usuario);
        if (!($verificarEstado)) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Autenticación',
                $accion = 5,
                $resultado = 3,
                $descripcion = 'Se intentó iniciar sesión con un usuario inhabilitado por intentos fallidos: '.$usuario,
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('advertencia', 'Acceso denegado, el usuario "'.$usuario.'" está inhabilitado, pase por oficinas de Sistemas para regularizar su cuenta.');
            return to_route('iniciar-sesion');
        }

        if ( Auth::attempt(['usuario_usuario'=> $usuario, 'password' => $clave ], false)) {
            try {
                $this->datosUsuariosAutenticados->reiniciarIntentosFallidosUsuario($usuario);

                $usuarioId = Auth::User()->usuario_id;
                $personId = Auth::User()->usuario_persona_id;

                $request->session()->get('datosPersona');
                $datosPersona = $this->datosUsuariosAutenticados->datosPersonaPorUsuarioId($usuarioId);
                $request->session()->put('datosPersona', $datosPersona);

                $request->session()->get('rolActivoUsuario');
                $rolInicialUsuario = $this->datosUsuariosAutenticados->rolInicialUsuarioPorUsuarioId($usuarioId);
                $request->session()->put('rolActivoUsuario', $rolInicialUsuario);
                
                $request->session()->get('aperturaActiva');
                $aperturaActiva = null;
                $request->session()->put('aperturaActiva', $aperturaActiva);
                
                if (empty(session('rolActivoUsuario')->rol_nombre)) {
                    Auth::guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    $this->actividades->registrarActividad(
                        $usuarioId = null,
                        $modulo = 'Autenticación',
                        $accion = 5,
                        $resultado = 2,
                        $descripcion = 'Error, rol no asignado para el usuario: '.$usuario,
                        $request->ip(),
                        $request->header('User-Agent')
                    );
                    session()->flash('informacion', 'Acceso denegado: el usuario no tiene asignado un rol, comuníquese con el administrador de Sistemas.');
                    return to_route('iniciar-sesion');
                }

                $request->session()->get('rolesUsuario');
                $rolesUsuario = $this->datosUsuariosAutenticados->rolesUsuarioPorUsarioId($usuarioId);
                $request->session()->put('rolesUsuario', $rolesUsuario);

                // $request->session()->get('nombreFotoPerfil');
                // $nombreFotoPerfil = $this->datosUsuariosAutenticados->nombreFotoPerfilPorPersonaId($personId);
                // $request->session()->put('nombreFotoPerfil', $nombreFotoPerfil);

                $request->session()->get('nombreFotoPerfil');
                $fotoPerfil = $this->datosUsuariosAutenticados->nombreFotoPerfilPorPersonaId($personId);
                $nombreArchivo = $fotoPerfil ? $fotoPerfil->foto_archivo : 'default.jpg';
                $request->session()->put('nombreFotoPerfil', $nombreArchivo);

                $request->session()->regenerate();//Averiguar la importancia del orden
                $this->actividades->registrarActividad(
                    $usuarioId,
                    $modulo = 'Autenticación',
                    $accion = 5,
                    $resultado = 1,
                    $descripcion = 'Inicio de sesión exitoso.',
                    $request->ip(),
                    $request->header('User-Agent')
                );
                // if (is_null(Auth::user()->usuario_estado)) {
                //     return redirect()->route('perfil.actualizar-clave');
                // }
                session()->flash('exito', 'Acceso correcto, bienvenido.');
                return redirect()->intended();
            } catch (\Throwable $th) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                $this->actividades->registrarActividad(
                    $usuarioId = null,
                    $modulo = 'Autenticación',
                    $accion = 5,
                    $resultado = 2,
                    $descripcion = 'Error, rol no asignado para el usuario: '.$usuario,
                    $request->ip(),
                    $request->header('User-Agent')
                );
                session()->flash('informacion', 'Acceso denegado: el usuario no tiene asignado un rol, comuníquese con el administrador de Sistemas.');
                return to_route('iniciar-sesion');
            }
        }
        $this->actividades->registrarActividad(
            $usuarioId = null,
            $modulo = 'Autenticación',
            $accion = 5,
            $resultado = 2,
            $descripcion = 'Error al intentar iniciar sesión para el usuario: '.$usuario,
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('iniciar-sesion');
    }

    public function destruir(Request $request)
    {
        $usuarioId = Auth::User()->usuario_id;
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Autenticación',
            $accion = 6,
            $resultado = 1,
            $descripcion = 'Cierre de sesión exitoso.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('informacion', 'Sesión finalizada satisfactoriamente.');
        return to_route('iniciar-sesion');
    }

    public function methodNotAllowed()
    {
        return to_route('inicio');
    }
    public function username()
    {
        return 'usuario_usuario';
    }
}
