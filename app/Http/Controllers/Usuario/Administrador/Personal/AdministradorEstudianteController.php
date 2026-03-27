<?php

namespace App\Http\Controllers\Usuario\Administrador\Personal;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\DatoUsuarioAutenticado;
use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorEstudianteController extends Controller
{
    private $actividades;
    private $datosUsuariosAutenticados;
    private $plantel;
    private $panelControl;

    private $gestion;
    private $periodo;

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
        $estudiantes = $this->plantel->informacionPersonalEstudiantesPorCi($ci);
        return view('usuario.administrador.personal.administrar-estudiantes', compact(
            'estudiantes','ci'
        ));
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'ci' => 'required',
            'ru' => 'required|integer',
            // 'primer_apellido' => 'nullable|alpha',
            // 'segundo_apellido' => 'nullable|alpha',
            'nombres' => 'required',
            'celular' => 'required|integer',
            'correo' => 'required',
        ]);
        $ci = $request->input('ci');

        $actualizar = $this->plantel->actualizarInformacionPersonalEstudiante($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Datos del estudiante con C.I. "'.$ci.'" actualizados correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos del estudiante con C.I. "'.$ci.'" ACTUALIZADOS CORRECTAMENTE.'); 
            return to_route('administrador.estudiantes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Estudiantes',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar los datos del estudiante con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.estudiantes');
    }
    public function agregar(Request $request)
    {
        $request->validate(['ci'=>'required', 'ru'=>'required|integer']);
        $ci = $request->input('ci');
        $ru = $request->input('ru');

        $agregar = $this->plantel->agregarEstudiantePorCi($ci, $ru);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Usuario con C.I. "'.$ci.'" agregado como estudiante correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Usuario con C.I. "'.$ci.'" AGREGADO COMO ESTUDIANTE CORRECTAMENTE.'); 
            return to_route('administrador.estudiantes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Estudiantes',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al agregar como estudiante al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.estudiantes');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $eliminar = $this->plantel->eliminarEstudiante($id);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Estudiante con C.I. "'.$ci.'" eliminado como estudiante correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Estudiante con C.I. "'.$ci.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.estudiantes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Estudiantes',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar como estudiante al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.estudiantes');
    }
    public function inhabilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $inhabilitar = $this->plantel->inhabilitarEstudiante($id);
        if ($inhabilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Estudiante con C.I. "'.$ci.'" inhabilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Estudiante con C.I. "'.$ci.'" INHABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.estudiantes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Estudiantes',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al inhabilitar al estudiante con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.estudiantes');
    }
    public function habilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $habilitar = $this->plantel->habilitarEstudiante($id);
        if ($habilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Estudiante con C.I. "'.$ci.'" habilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Estudiante con C.I. "'.$ci.'" HABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.estudiantes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Estudiantes',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al habilitar al estudiante con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.estudiantes');
    }
}
