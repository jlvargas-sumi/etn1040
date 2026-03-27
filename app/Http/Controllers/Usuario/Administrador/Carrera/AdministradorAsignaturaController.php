<?php

namespace App\Http\Controllers\Usuario\Administrador\Carrera;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorAsignaturaController extends Controller
{
    private $actividades;
    private $carrera;
    private $asignaturas;
    private $panelControl;

    private $planEstudiosId;
    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->carrera = new Carrera;
        $this->asignaturas = new Asignatura;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->planEstudiosId = $panelControl->plan_estudio_id;
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($planEstudiosId = null, $mencionId = 1)
    {
        $planEstudiosId = empty($planEstudiosId) ? $this->planEstudiosId:$planEstudiosId;
        $planesEstudios = $this->carrera->planesEstudios();
        $menciones = $this->carrera->menciones();
        $semestres = $this->carrera->semestres();
        $asignaturas = $this->asignaturas->asignaturasPorPlanEstudiosMencionId($planEstudiosId, $mencionId);
        $asignaturasGeneral = $this->asignaturas->asignaturasPorPlanEstudiosId($planEstudiosId);

        return view('usuario.administrador.carrera.administrar-asignaturas', compact(
            'asignaturas', 'planesEstudios', 'planEstudiosId', 'menciones', 'mencionId', 'semestres', 'asignaturasGeneral'
        ));
    }
    public function buscar(Request $request)
    {
        $request->validate([
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
        ]);

        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');

        return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
    }
    public function crear(Request $request)
    {
        $request->validate([
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'sigla' => 'required',
            'asignatura' => 'required',
            'menciones_id' => 'required|array',
            'semestres_id' => 'required|array',
        ]);

        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $sigla = $request->input('sigla');
        $asignatura = $request->input('asignatura');
        $usuarioId = Auth::User()->usuario_id;

        $crear = $this->asignaturas->crearAsignatura($request);
        if ($crear) {
            $this->actividades->registrarActividad(
                $usuarioId,
                $modulo = 'Asignaturas',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Asignatura "'.$asignatura.' ('.$sigla.')" creada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Asignatura "'.$asignatura.' ('.$sigla.')" CREADA CORRECTAMENTE.');
            return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
        }
        $this->actividades->registrarActividad(
            $usuarioId,
            $modulo = 'Asignaturas',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al crear la asignatura "'.$asignatura.' ('.$sigla.')".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
    }
    public function agregar(Request $request)
    {
        $request->validate([
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'asignatura_id' => 'required|integer',
            'semestre_id' => 'required|integer'
        ]);

        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $asignaturaId = $request->input('asignatura_id');

        $asignatura = $this->asignaturas->asignaturaPorId($asignaturaId);

        $crear = $this->asignaturas->agregarAsignatura($request);
        if ($crear) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Asignaturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Asignatura "'.$asignatura->asignatura_nombre.' ('.$asignatura->asignatura_sigla.')" agregada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Asignatura "'.$asignatura->asignatura_nombre.' ('.$asignatura->asignatura_sigla.')" AGREGADA CORRECTAMENTE.');
            return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Asignaturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al agregar la asignatura "'.$asignatura->asignatura_nombre.' ('.$asignatura->asignatura_sigla.')".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
    }
    public function actualizar(Request $request)
    {
        // return $request->all();
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'sigla' => 'required',
            'asignatura' => 'required',
        ]);
        
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $sigla = $request->input('sigla');
        $asignatura = $request->input('asignatura');

        $actualizar = $this->asignaturas->actualizarAsignatura($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Asignaturas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Asignatura "'.$asignatura.' ('.$sigla.')" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Asignatura "'.$asignatura.' ('.$sigla.')" ACTUALIZADA CORRECTAMENTE.');
            return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Asignaturas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar la asignatura "'.$asignatura.' ('.$sigla.')".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
    }
    public function eliminar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudios_id' => 'required|integer',
            'mencion_id' => 'required|integer',
            'sigla' => 'required',
            'asignatura' => 'required',
        ]);

        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $sigla = $request->input('sigla');
        $asignatura = $request->input('asignatura');

        $eliminar = $this->asignaturas->eliminarAsignatura($request);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Asignaturas',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Asignatura "'.$asignatura.' ('.$sigla.')" eliminada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Asignatura "'.$asignatura.' ('.$sigla.')" ELIMINADA CORRECTAMENTE.');
            return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Asignaturas',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar la asignatura "'.$asignatura.' ('.$sigla.')".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.asignaturas', [$planEstudiosId, $mencionId]);
    }
}
