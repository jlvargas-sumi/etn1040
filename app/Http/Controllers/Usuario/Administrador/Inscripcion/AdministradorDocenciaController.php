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

class AdministradorDocenciaController extends Controller
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
        $docentes = $this->plantel->docentes(1);
        $aulas = $this->carrera->aulas(1);
        $docencias = $this->asignaturas->aperturasHabilitadasParaDocencias($planEstudiosId, $mencionId, $periodo, $gestion);
        // return $docencias;
        return view('usuario.administrador.inscripcion.administrar-docencias', compact(
            'docencias', 'docentes', 'aulas', 'planesEstudios', 'planEstudiosId', 'menciones', 'mencionId', 'periodo', 'gestion'
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
            'apertura_id' => 'required|integer',
            'clases' => 'required'
        ]);

        $paralelo = $request->input('paralelo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $actualizar = $this->asignaturas->actualizarDocencia($request);
        
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Docencia de la asignatura "'.$sigla.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Horario del paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docencias',
            $accion = 3,
            $resultado = 1,
            $descripcion = 'Error al actualizar la docencia de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function crearClase(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'clase' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $clase = $request->input('clase');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->crearClase($request);
        
        if ($crear === "Duplicado") { 
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 1,
                $resultado = 3,
                $descripcion = 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" duplicada.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('error', 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" DUPLICADA.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
        elseif ($crear === true) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" creada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" CREADA CORRECTAMENTE.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        } 
        else{
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 1,
                $resultado = 2,
                $descripcion = 'Error al crear la clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'".',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
    }
    public function actualizarClase(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'clase' => 'required',
            'clase_actual' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $clase = $request->input('clase');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->actualizarClase($request);
        
        if ($crear === "Duplicado") { 
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 3,
                $resultado = 3,
                $descripcion = 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" duplicada.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('error', 'Clase "'.$clase.'" de la asignatura "'.$sigla.'" DUPLICADA.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
        elseif ($crear === true) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" ACTUALIZADA CORRECTAMENTE.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        } 
        else{
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 3,
                $resultado = 2,
                $descripcion = 'Error al actualizar la clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'".',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
    }
    public function eliminarClase(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'clase' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $clase = $request->input('clase');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $eliminar = $this->asignaturas->eliminarClase($request);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docencias',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" eliminada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'" ELIMINADA CORRECTAMENTE.'); 
            return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docencias',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar la clase "'.$clase.'" de docencia para la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        ); 
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.docencias', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
}
