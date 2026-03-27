<?php

namespace App\Http\Controllers\Usuario\Administrador\Personal;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorAdministrativoController extends Controller
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
        $administrativos = $this->plantel->informacionPersonalAdministrativosPorCi($ci);
        $cargos = $this->plantel->cargos();
        return view('usuario.administrador.personal.administrar-administrativos', compact(
            'administrativos','ci','cargos'
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
            'cargo_id' => 'required|integer'
        ]);
        $ci = $request->input('ci');

        $actualizar = $this->plantel->actualizarInformacionPersonalAdministrativo($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Datos del administrativo con C.I. "'.$ci.'" actualizados correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos del administrativo con C.I. "'.$ci.'" ACTUALIZADOS CORRECTAMENTE.'); 
            return to_route('administrador.administrativos');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar los datos del administrativo con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.administrativos');
    }
    public function agregar(Request $request)
    {
        $request->validate(['ci'=>'required', 'cargo_id' => 'required|integer']);
        $ci = $request->input('ci');
        $cargoId = $request->input('cargo_id');

        $agregar = $this->plantel->agregarAdministrativoPorCi($ci, $cargoId);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Usuario con C.I. "'.$ci.'" agregado como administrativo correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Usuario con C.I. "'.$ci.'" AGREGADO COMO ADMINISTRATIVO CORRECTAMENTE.'); 
            return to_route('administrador.administrativos');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al agregar como administrativo al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.administrativos');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $eliminar = $this->plantel->eliminarAdministrativo($id);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Administrativo con C.I. "'.$ci.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Administrativo con C.I. "'.$ci.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.administrativos');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar al administrativo con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.administrativos');
    }
    public function inhabilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $inhabilitar = $this->plantel->inhabilitarAdministrativo($id);
        if ($inhabilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Administrativo con C.I. "'.$ci.'" inhabilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Administrativo con C.I. "'.$ci.'" INHABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.administrativos');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al inhabilitar al administrativo con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.administrativos');
    }
    public function habilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $habilitar = $this->plantel->habilitarAdministrativo($id);
        if ($habilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Administrativo con C.I. "'.$ci.'" habilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Administrativo con C.I. "'.$ci.'" HABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.administrativos');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al habilitar al administrativo con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.administrativos');
    }
}
