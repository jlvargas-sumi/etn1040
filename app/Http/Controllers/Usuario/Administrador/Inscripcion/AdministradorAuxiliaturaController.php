<?php

namespace App\Http\Controllers\Usuario\Administrador\Inscripcion;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorAuxiliaturaController extends Controller
{
    private $actividades;
    private $asignaturas;
    private $carrera;
    private $plantel;
    private $panelControl;

    private $periodo;
    private $gestion;
    private $planEstudiosId;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->asignaturas = new Asignatura;
        $this->carrera = new Carrera;
        $this->plantel = new Plantel;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->planEstudiosId = $panelControl->plan_estudio_id;
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($planEstudiosId = null, $mencionId = null, $periodo = null, $gestion = null)
    {
        if (empty($planEstudiosId)) {
            $planEstudiosId = $this->planEstudiosId;
            $mencionId = 0;
            $periodo = $this->periodo;
            $gestion = $this->gestion;
        }
        return $this->resultado($planEstudiosId, $mencionId, $periodo, $gestion);
    }
    public function resultado($planEstudiosId, $mencionId, $periodo, $gestion)
    {
        $planesEstudios = $this->carrera->planesEstudios();
        $menciones = $this->carrera->menciones();
        $auxiliares = $this->plantel->auxiliares(1);
        $aulas = $this->carrera->aulas(1);
        $auxiliaturas = $this->asignaturas->aperturasHabilitadasParaAuxiliaturas($planEstudiosId, $mencionId, $periodo, $gestion);
        return view('usuario.administrador.inscripcion.administrar-auxiliaturas', compact(
            'auxiliaturas', 'auxiliares', 'aulas', 'planesEstudios', 'planEstudiosId', 'menciones', 'mencionId', 'periodo', 'gestion'
        ));
    }
    public function buscar(Request $request)
    {
        $request->validate([
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer'
        ]);
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');

        return $this->resultado($planEstudiosId, $mencionId, $periodo, $gestion);
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
            'paralelo' => 'required',
            'grupo' => 'required|integer',
            'apertura_id' => 'required|integer',
            'clases' => 'required'
        ]);

        $grupo = $request->input('grupo');
        $paralelo = $request->input('paralelo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $actualizar = $this->asignaturas->actualizarAuxiliatura($request);
        
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Auxiliatura de la asignatura "'.$sigla.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Horario del grupo "'.$grupo.'" paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliaturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar auxiliatura de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function crearGrupo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'grupo' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $grupo = $request->input('grupo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->crearGrupo($request);
        
        if ($crear === "Duplicado") {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 1,
                $resultado = 3,
                $descripcion = 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" duplicado.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('error', 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" DUPLICADO.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
        elseif ($crear === true) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" creado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" CREADO CORRECTAMENTE.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        } 
        else{
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 1,
                $resultado = 2,
                $descripcion = 'Error al crear el grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'".',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
    }
    public function actualizarGrupo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'grupo' => 'required',
            'grupo_actual' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $grupo = $request->input('grupo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->actualizarGrupo($request);
        
        if ($crear === "Duplicado") { 
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 3,
                $resultado = 3,
                $descripcion = 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" duplicado.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('error', 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" DUPLICADO.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
        elseif ($crear === true) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" actualizado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        } 
        else{
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 3,
                $resultado = 2,
                $descripcion = 'Error al actualizar el grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'".',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
    }
    public function eliminarGrupo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'grupo' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $grupo = $request->input('grupo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $eliminar = $this->asignaturas->eliminarGrupo($request);
        
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliaturas',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Grupo "'.$grupo.'" de la asignatura "'.$sigla.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        } 
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliaturas',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar el grupo "'.$grupo.'" de auxiliatura para la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.auxiliaturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
}
