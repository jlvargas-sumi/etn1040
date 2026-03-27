<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\FotoRequest;
use App\Http\Requests\ActualizarClaveRequest;

use App\Models\DatoUsuarioAutenticado;
use App\Models\Asignatura;
use App\Models\Actividad;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PerfilController extends Controller
{
    private $datosUsuariosAutenticados;
    private $asignaturas;
    private $actividades;

    public function __construct()
    {
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
        $this->asignaturas = new Asignatura;
        $this->actividades = new Actividad;
    }

    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth'),
        ];
    }

    public function indice()
    {
        $informacionPersonal = $this->datosUsuariosAutenticados->informacionPersonalPorPersonaId(Auth::User()->usuario_persona_id);
        return view('auth.perfil', ['informacionPersonal' => $informacionPersonal]);
    }

    public function cambiarRol(Request $request)
    {
        $rol = $request->input('rol');
        $usuarioId = Auth::User()->usuario_id;

        $nuevoRolUsuario = $this->datosUsuariosAutenticados->rolPorUsuarioIdRol($usuarioId, $rol);
        if (!empty($nuevoRolUsuario->rol_nombre)) {
            $request->session()->get('rolActivoUsuario');
            $request->session()->put('rolActivoUsuario', $nuevoRolUsuario);

            $request->session()->regenerate();
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Rol cambiado a "'.$rol.'" exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Rol cambiado a "'.$rol.'" exitosamente.');
            return to_route('inicio');
        }
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Perfil',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al cambiar rol "'.$rol.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('inicio');
    }

    public function cambiarApertura(Request $request)
    {
        $id = $request->input('id');
        
        $nuevaApertura = $this->asignaturas->aperturaPorId($id);
        if (!empty($nuevaApertura)) {
            $request->session()->get('aperturaActiva');
            $request->session()->put('aperturaActiva', $nuevaApertura);

            $request->session()->regenerate();
            
            return true;
        }
        else{
            return false;
        }
    }

    public function subirFotoPerfil(FotoRequest $request)
    {
        $foto = $request->validated('foto');
        $nombreFoto = 'foto_'.session('datosPersona')->persona_ci.'.'.$foto->extension();
        $personaId = Auth::User()->usuario_persona_id;
        $usuarioId = Auth::User()->usuario_id;

        $verificarFotoPerfil = $this->datosUsuariosAutenticados->verificarFotoPerfilPorPersonaId($personaId);
        if ($verificarFotoPerfil) {
            $actualizarFotoPerfil = $this->datosUsuariosAutenticados->actualizarFotoPerfilPorPersonaId($personaId, $foto, $nombreFoto);
            if ($actualizarFotoPerfil) {
                $fotoPerfil = $this->datosUsuariosAutenticados->nombreFotoPerfilPorPersonaId($personaId);
            
                $request->session()->get('nombreFotoPerfil');
                $nombreArchivo = $fotoPerfil ? $fotoPerfil->foto_archivo : 'default.jpg';
                $request->session()->put('nombreFotoPerfil', $nombreArchivo);
                
                $request->session()->regenerate();
                $this->actividades->registrarActividad(
                    $usuarioId,
                    $modulo = 'Perfil',
                    $accion = 3,
                    $resultado = 1,
                    $descripcion = 'Fotografía actualizada exitosamente.',
                    $request->ip(),
                    $request->header('User-Agent')
                );
                session()->flash('exito', 'Fotografía Actualizada exitosamente.');
                return to_route("perfil");
            }
        }
        $subirFotoPerfil = $this->datosUsuariosAutenticados->subirFotoPerfilPorPersonaId($personaId, $foto, $nombreFoto);
        
        if ($subirFotoPerfil) {
            $fotoPerfil = $this->datosUsuariosAutenticados->nombreFotoPerfilPorPersonaId($personaId);
        
            $request->session()->get('nombreFotoPerfil');
            $nombreArchivo = $fotoPerfil ? $fotoPerfil->foto_archivo : 'default.jpg';
            $request->session()->put('nombreFotoPerfil', $nombreArchivo);
            
            $request->session()->regenerate();
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Fotografía subida exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Fotografía Subida exitosamente.');
            return to_route("perfil");
        }       
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Perfil',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al subir fotografía.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('perfil');
    }
    
    public function actualizarDomicilio(Request $request)
    {
        $request->validate(['domicilio' => 'required']);
        $domicilio = $request->input('domicilio');

        $personaId = Auth::User()->usuario_persona_id;
        $usuarioId = Auth::User()->usuario_id;

        $actualizarDomicilio = $this->datosUsuariosAutenticados->actualizarDomicilioPorPersonaId($personaId, $domicilio);
        if ($actualizarDomicilio) {
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Domicilio actualizado exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Domicilio "'.$domicilio.'" Actualizado exitosamente.');
            return to_route("perfil");
        }
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Perfil',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar domicilio.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('perfil');
    }

    public function actualizarCorreo(Request $request)
    {
        $request->validate(['correo' => 'required']);
        $correo = $request->input('correo');

        $personaId = Auth::User()->usuario_persona_id;
        $usuarioId = Auth::User()->usuario_id;

        $verificarCorreo = $this->datosUsuariosAutenticados->verificarCorreo($correo);
        if ($verificarCorreo){
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 3,
                $descripcion = 'El Correo "'.$correo.'" ya está registrado.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'correo' => 'El Correo "'.$correo.'" ya está registrado, ingrese otro correo.',
            ])->onlyInput('correo');
        }

        $actualizarCorreo = $this->datosUsuariosAutenticados->actualizarCorreoPorPersonaId($personaId, $correo);
        if ($actualizarCorreo) {
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Correo "'.$correo.'" actualizado exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Correo "'.$correo.'" Actualizado exitosamente.');
            return to_route("perfil");
        }
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Perfil',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar correo.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('perfil');
    }

    public function actualizarCelular(Request $request)
    {
        $request->validate([
            // 'codigo' => 'required', 
            'celular' => 'required']);
        $codigo = $request->input('codigo') ?? 591;
        $celular = $request->input('celular');

        $personaId = Auth::User()->usuario_persona_id;
        $usuarioId = Auth::User()->usuario_id;
        
        $verificarCodigoPais = $this->datosUsuariosAutenticados->verificarCodigoPais($codigo);
        if (!($verificarCodigoPais)){
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 3,
                $descripcion = 'El Código de País "'.$codigo.'" NO existe.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'codigo' => 'El Código de País "'.$codigo.'" NO existe, ingrese otro número.',
            ])->onlyInput('codigo');
        }

        $verificarCelular = $this->datosUsuariosAutenticados->verificarCelular($codigo, $celular);
        if ($verificarCelular){
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 3,
                $descripcion = 'El Número "+'.$codigo.' '.$celular.'" ya está registrado.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'celular' => 'El Número "+'.$codigo.' '.$celular.'" ya está registrado, ingrese uno nuevo.',
            ])->onlyInput('celular');
        }

        $actualizarCelular = $this->datosUsuariosAutenticados->actualizarCelularPorPersonaId($personaId, $codigo, $celular);
        if ($actualizarCelular){
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Número de Celular "+'.$codigo.' '.$celular.'" Actualizado exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Número de Celular "+'.$codigo.' '.$celular.'" Actualizado exitosamente.');
            return to_route('perfil');
        }
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Perfil',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar número de celular "+'.$codigo.' '.$celular.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('perfil');
    }

    public function actualizarClave(ActualizarClaveRequest $request)
    {
        $clave_actual = $request->validated('clave_actual');
        $clave = bcrypt($request->validated('password'));
        
        $usuarioId = Auth::User()->usuario_id;

        $verificarClave = $this->datosUsuariosAutenticados->verificarClavePorUsuarioId($usuarioId, $clave_actual);
        if (!($verificarClave)){
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 3,
                $descripcion = 'Acceso denegado, contraseña incorrecta.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->withErrors([
                'clave_actual' => 'Acceso denegado, contraseña incorrecta.',
            ])->onlyInput('clave_actual');
        }

        $actualizarClave = $this->datosUsuariosAutenticados->actualizarClave($usuarioId, $clave);
        if ($actualizarClave) {
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Perfil',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Contraseña actualizada exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Contraseña actualizada exitosamente.');
            return to_route('perfil');
        }
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Perfil',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar la contraseña.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('perfil');       
    } 
}
