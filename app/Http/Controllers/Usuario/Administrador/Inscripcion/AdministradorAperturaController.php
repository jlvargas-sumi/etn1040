<?php

namespace App\Http\Controllers\Usuario\Administrador\Inscripcion;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorAperturaController extends Controller
{
    private $actividades;
    private $asignaturas;
    private $carrera;
    private $panelControl;

    private $periodo;
    private $gestion;
    private $planEstudiosId;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->asignaturas = new Asignatura;
        $this->carrera = new Carrera;
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
        $aperturas = $this->asignaturas->aperturasHabilitadasParaInscripcion($planEstudiosId, $mencionId, $periodo, $gestion);
        // return $aperturas;
        return view('usuario.administrador.inscripcion.administrar-aperturas', compact(
            'aperturas', 'planesEstudios', 'planEstudiosId', 'menciones', 'mencionId', 'periodo', 'gestion'
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
    public function actualizarParalelo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'paralelo' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $paralelo = $request->input('paralelo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $actualizar = $this->asignaturas->actualizarParalelo($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'" actualizado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar el paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function eliminarParalelo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'paralelo' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $id = $request->input('id');
        $paralelo = $request->input('paralelo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $eliminar = $this->asignaturas->eliminarParalelo($id);
        
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar el paralelo "'.$paralelo.'" de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function crearParalelo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'paralelo' => 'required',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $paralelo = $request->input('paralelo');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->crearParalelo($request);
        
        if ($crear) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Paralelo "'.$paralelo.'" para la asignatura "'.$sigla.'" creado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Paralelo "'.$paralelo.'" para la asignatura "'.$sigla.'" CREADO CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al crear el paralelo "'.$paralelo.'" para la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function LaboratorioIndependiente(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $id = $request->input('id');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $habilitar = $this->asignaturas->LaboratorioIndependiente($id);
        
        if ($habilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Laboratorio de la asignatura "'.$sigla.'" cambiado a independiente correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Laboratorio de la asignatura "'.$sigla.'" CAMBIADO A INDEPENDIENTE CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al cambiar a independiente el laboratorio de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function LaboratorioDependiente(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $id = $request->input('id');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $deshabilitar = $this->asignaturas->LaboratorioDependiente($id);
        
        if ($deshabilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Laboratorio de la asignatura "'.$sigla.'" cambiado a dependiente correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Laboratorio de la asignatura "'.$sigla.'" CAMBIADO A DEPENDIENTE CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al cambiar a dependiente el laboratorio de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function crearLaboratorio(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $id = $request->input('id');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->crearLaboratorio($id);
        
        if ($crear) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Laboratorio para la asignatura "'.$sigla.'" creado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Laboratorio para la asignatura "'.$sigla.'" CREADO CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al crear el laboratorio para la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function eliminarLaboratorio(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $id = $request->input('id');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $eliminar = $this->asignaturas->eliminarLaboratorio($id);
        
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Laboratorio de la asignatura "'.$sigla.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Laboratorios correspondientes a la asignatura "'.$sigla.'" ELIMINADOS CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar laboratorio de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function habilitar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $id = $request->input('id');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $habilitar = $this->asignaturas->habilitar($id);
        
        if ($habilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Apertura de la asignatura "'.$sigla.'" habilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Apertura de la asignatura "'.$sigla.'" HABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al habilitar la apertura de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
    public function deshabilitar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $id = $request->input('id');
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $deshabilitar = $this->asignaturas->deshabilitar($id);
        
        if ($deshabilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aperturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Apertura de la asignatura "'.$sigla.'" deshabilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Apertura de la asignatura "'.$sigla.'" DESHABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]); 
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aperturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al deshabilitar la apertura de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aperturas', [$planEstudiosId, $mencionId, $periodo, $gestion]);
    }
}
