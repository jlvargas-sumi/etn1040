<?php

namespace App\Http\Controllers\Usuario\Administrador\Personal;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\DatoUsuarioAutenticado;
use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorUsuarioController extends Controller
{
    private $actividades;
    private $datosUsuariosAutenticados;
    private $plantel;
    private $panelControl;

    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
        $this->plantel = new Plantel;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($ci = null)
    {
        $roles = $this->datosUsuariosAutenticados->roles();
        $categorias = $this->plantel->categorias();
        $cargos = $this->plantel->cargos();

        $usuarios = $this->datosUsuariosAutenticados->informacionPersonalUsuariosPorCi($ci);
        return view('usuario.administrador.personal.administrar-usuarios', compact(
            'usuarios','ci', 'roles', 'categorias', 'cargos'
        ));
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'ci' => 'required',
            // 'primer_apellido' => 'nullable|alpha',
            // 'segundo_apellido' => 'nullable|alpha',
            'nombres' => 'required',
            'celular' => 'required|integer',
            'correo' => 'required',
        ]);
        $ci = $request->input('ci');

        $actualizar = $this->datosUsuariosAutenticados->actualizarInformacionPersonalUsuario($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Usuarios',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Datos del usuario con C.I. "'.$ci.'" actualizados correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos del usuario con C.I. "'.$ci.'" ACTUALIZADOS CORRECTAMENTE.'); 
            return to_route('administrador.usuarios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Usuarios',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar los datos del usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.usuarios');
    }
    public function crear(Request $request)
    {
        $request->validate([
            'nombres' => ['required'],
            'ci' => ['required'],
            'celular' => ['required'],
            'correo' => ['required'],
            'rol_id' => ['required'],
        ]);

        $ci = $request->input('ci');

        $agregar = $this->datosUsuariosAutenticados->crearUsuario($request);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Usuarios',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Usuario con C.I. "'.$ci.'" agregado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Usuario con C.I. "'.$ci.'" AGREGADO CORRECTAMENTE.'); 
            return to_route('administrador.usuarios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Usuarios',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al agregar al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.usuarios');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $eliminar = $this->datosUsuariosAutenticados->eliminarUsuario($id);
        return $eliminar;
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Usuarios',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Usuario con C.I. "'.$ci.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Usuario con C.I. "'.$ci.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.usuarios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Usuarios',
            $accion = 4,
            $resultado = 3,
            $descripcion = 'Error al eliminar al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('informacion', 'Operación cancelada, los datos a eliminar están relacionados con otros registros.'); 
        return to_route('administrador.usuarios');
    }
    public function reiniciarClave(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $reiniciar = $this->datosUsuariosAutenticados->reiniciarClave($id);
        if ($reiniciar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Usuarios',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Contraseña del usuario con C.I. "'.$ci.'" reiniciada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Contraseña de Usuario con C.I. "'.$ci.'" REINICIADO CORRECTAMENTE.'); 
            return to_route('administrador.usuarios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Usuarios',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al reiniciar la contraseña del usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.usuarios');
    }
    public function inhabilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $inhabilitar = $this->datosUsuariosAutenticados->inhabilitarUsuario($id);
        if ($inhabilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Usuarios',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Usuario con C.I. "'.$ci.'" inhabilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Usuario con C.I. "'.$ci.'" INHABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.usuarios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Usuarios',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al inhabilitar al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.usuarios');
    }
    public function habilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $habilitar = $this->datosUsuariosAutenticados->habilitarUsuario($id);
        if ($habilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Usuarios',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Usuario con C.I. "'.$ci.'" habilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Usuario usuario con C.I. "'.$ci.'" HABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.usuarios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Usuarios',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al habilitar al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.usuarios');
    }
}
