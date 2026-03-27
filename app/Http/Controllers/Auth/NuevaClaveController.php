<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\NuevaClaveRequest;

use App\Models\DatoUsuarioAutenticado;
use App\Models\Actividad;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NuevaClaveController extends Controller implements HasMiddleware
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
            new Middleware(middleware: 'guest'),
        ];
    }

    public function indice()
    {
        return view('auth.nueva-clave');
    }

    public function actualizar(NuevaClaveRequest $request)
    {
        $codigo = $request->validated('codigo');
        $usuario = $request->validated('usuario');
        $clave = bcrypt($request->validated('password'));
        
        $verificarUsuario = $this->datosUsuariosAutenticados->verificarUsuario($usuario);
        if (!($verificarUsuario)) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Recuperar clave',
                $accion = 2,
                $resultado = 3,
                $descripcion = 'El Usuario "'.$usuario.'" no se encuentra registrado.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'usuario' => 'El Usuario no se encuentra registrado.',
            ])->onlyInput('codigo', 'usuario');
        }

        $verificarUltimoCodigo = $this->datosUsuariosAutenticados->verificarUltimoCodigoPorUsuarioCodigo($usuario, $codigo);
        if (!($verificarUltimoCodigo)) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Recuperar clave',
                $accion = 2,
                $resultado = 3,
                $descripcion = 'El código no corresponde a la última solicitud del usuario "'.$usuario.'".',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'codigo' => 'Contraseña NO actualizada, el código no corresponde a la última solicitud de usuario; revise su correo.',
            ])->onlyInput('codigo', 'usuario');
        }

        $verificarEstado = $this->datosUsuariosAutenticados->verificarEstadoPorCodigo($codigo);
        if (!($verificarEstado)) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Recuperar clave',
                $accion = 2,
                $resultado = 3,
                $descripcion = 'El código "'.$codigo.'" ya fue utilizado.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('error', 'Contraseña NO actualizada, el código ya fué utilizado; solicite uno nuevo.');
            return to_route('solicitud-codigo-correo')->onlyInput('usuario');
        }

        $actualizarClave = $this->datosUsuariosAutenticados->actualizarClavePorUsuarioCodigo($usuario, $clave, $codigo);
        if ($actualizarClave) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Recuperar clave',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Contraseña del usuario "'.$usuario.'" recuperada exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Contraseña recuperada exitosamente, ingrese con su nueva contraseña.');
            return to_route('iniciar-sesion');
        }
        $this->actividades->registrarActividad(
            $usuarioId = null,
            $modulo = 'Recuperar clave',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al recuperar la contraseña.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('nueva-clave');
    }
}