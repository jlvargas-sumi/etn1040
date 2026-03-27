<?php

namespace App\Http\Controllers\Usuario\Administrador\Carrera;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Carrera;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorPlanEstudioController extends Controller
{
    private $actividades;
    private $carrera;
    private $panelControl;

    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->carrera = new Carrera;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice()
    {
        $planesEstudios = $this->carrera->planesEstudios();
        return view('usuario.administrador.carrera.administrar-planes-estudios', compact(
            'planesEstudios'
        ));
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudio' => 'required',
        ]);
        $planEstudio = $request->input('plan_estudio');

        $actualizar = $this->carrera->actualizarPlanEstudio($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Planes de Estudio',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Plan de Estudio "'.$planEstudio.'" actualizado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos de plan de estudio "'.$planEstudio.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.planes-estudios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Planes de Estudio',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar el plan de estudio "'.$planEstudio.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.planes-estudios');
    }
    public function crear(Request $request)
    {
        $request->validate([
            'plan_estudio' => ['required'],
        ]);

        $planEstudio = $request->input('plan_estudio');

        $agregar = $this->carrera->crearPlanEstudio($request);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Planes de Estudio',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Plan de Estudio "'.$planEstudio.'" creado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Plan de Estudio "'.$planEstudio.'" CREADO CORRECTAMENTE.'); 
            return to_route('administrador.planes-estudios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Planes de Estudio',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al crear el plan de estudio "'.$planEstudio.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.planes-estudios');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'plan_estudio'=>'required']);
        $id = $request->input('id');
        $planEstudio = $request->input('plan_estudio');

        $eliminar = $this->carrera->eliminarPlanEstudio($id);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Planes de Estudio',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Plan de Estudio "'.$planEstudio.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Plan de Estudio "'.$planEstudio.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.planes-estudios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Planes de Estudio',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar el plan de estudio "'.$planEstudio.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.planes-estudios');
    }
}
