<?php

namespace App\Http\Controllers\Usuario\Administrador\Personal;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorAuxiliarController extends Controller
{
    private $actividades;
    private $plantel;
    private $panelControl;

    private $periodo;
    private $gestion;
    
    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->plantel = new Plantel;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($ci = null)
    {
        $auxiliares = $this->plantel->informacionPersonalAuxiliaresPorCi($ci);
        return view('usuario.administrador.personal.administrar-auxiliares', compact(
            'auxiliares','ci'
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

        $actualizar = $this->plantel->actualizarInformacionPersonalAuxiliar($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Datos del auxiliar con C.I. "'.$ci.'" actualizados correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos del auxiliar con C.I. "'.$ci.'" ACTUALIZADOS CORRECTAMENTE.'); 
            return to_route('administrador.auxiliares');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar los datos del auxiliar con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.auxiliares');
    }
    public function agregar(Request $request)
    {
        $request->validate(['ru'=>'required|integer']);
        $ru = $request->input('ru');

        $agregar = $this->plantel->agregarAuxiliarPorRu($ru);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Estudiante con R.U. "'.$ru.'" agregado como auxiliar correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Estudiante con R.U. "'.$ru.'" AGREGADO COMO AUXILIAR CORRECTAMENTE.'); 
            return to_route('administrador.auxiliares');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al agregar como auxiliar al estudiante con R.U. "'.$ru.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.auxiliares');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $eliminar = $this->plantel->eliminarAuxiliar($id);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Auxiliar con C.I. "'.$ci.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Auxiliar con C.I. "'.$ci.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.auxiliares');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar al auxiliar con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.auxiliares');
    }
    public function inhabilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $inhabilitar = $this->plantel->inhabilitarAuxiliar($id);
        if ($inhabilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Auxiliar con C.I. "'.$ci.'" inhabilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Auxiliar con C.I. "'.$ci.'" INHABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.auxiliares');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al inhabilitar al auxiliar con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.auxiliares');
    }
    public function habilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $habilitar = $this->plantel->habilitarAuxiliar($id);
        if ($habilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Auxiliar con C.I. "'.$ci.'" habilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Auxiliar con C.I. "'.$ci.'" HABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.auxiliares');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al habilitar al auxiliar con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.auxiliares');
    }
}
