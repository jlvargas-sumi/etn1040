<?php

namespace App\Http\Controllers\Usuario\Estudiante;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\DatoUsuarioAutenticado;
use App\Models\Plantel;
use App\Models\Asignatura;
use App\Models\PanelControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Dompdf\Options;

class InscripcionController extends Controller
{
    private $actividades;
    private $datosUsuariosAutenticados;
    private $plantel;
    private $asignaturas;
    private $panelControl;

    private $personaId;
    
    private $planEstudios;
    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
        $this->plantel = new Plantel;
        $this->asignaturas = new Asignatura;
        $this->panelControl = new PanelControl;
        
        $this->personaId = Auth::User()->usuario_persona_id;
        
        $panelControl = $this->panelControl->panelControlActual();
        $this->planEstudios = $panelControl->plan_estudio_nombre;
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($periodo = null, $gestion = null)
    {
        $periodo = empty($periodo) ? $this->periodo:$periodo;
        $gestion = empty($gestion) ? $this->gestion:$gestion;
        $estadoInscripcion = $this->panelControl->estadoInscripcionPorPeriodoGestion($periodo, $gestion);
        $estudianteId = $this->plantel->estudianteIdPorPersonaId($this->personaId);
        $asignaturasInscritas = $this->asignaturas->asignaturasInscritasPorPersonaId($this->personaId, $periodo, $gestion);
        $asignaturasHabilitadas = $this->asignaturas->asignaturasHabilitadasParaInscripcion($estudianteId, $this->planEstudios, $periodo, $gestion);
        $paralelos = $this->asignaturas->paralelosHabilitadosParaInscripcion($this->planEstudios, $periodo, $gestion);
        
        return view('usuario.estudiante.inscripciones', compact(
                'estadoInscripcion',
                'periodo',
                'gestion',
                'asignaturasInscritas',
                'asignaturasHabilitadas',
                'paralelos'
            )
        );
    }

    public function registrarInscripcion(Request $request)
    {

        $request->validate([
            'apertura_id' => ['required', 'integer', 'min:0'],
            'asignatura' => ['required'],
            'periodo' => ['required',],
            'gestion' => ['required', 'integer', 'min:0'],
        ]);

        $aperturaId = $request->input('apertura_id');
        $asignatura = $request->input('asignatura');

        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');

        $estudianteId = $this->asignaturas->estudianteIdPorPersonaId($this->personaId);

        $registrarInscripcion = $this->asignaturas->registrarInscripciones($estudianteId, $aperturaId);

        if ($registrarInscripcion) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes - Inscripciones',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Registro de inscripción en la asignatura "'.$asignatura.'" realizado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Registro de inscripción en la asignatura "'.$asignatura.'" REALIZADO CORRECTAMENTE.');
            return to_route('estudiante.inscripciones', [$periodo, $gestion]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Estudiantes - Inscripciones',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error en el registro de inscripción en la asignatura "'.$asignatura.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error interno, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('estudiante.inscripciones', [$periodo, $gestion]);
    }

    public function buscar(Request $request)
    {
        $request->validate(['periodo' => 'required']);
        $request->validate(['gestion' => 'required|integer']);

        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');

        return to_route('estudiante.inscripciones', [$periodo, $gestion]);
     }

    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required']);
        $inscripcionId = $request->input('id');

        $asignatura = $this->asignaturas->asignaturaPorInscripcionId($inscripcionId);
        $campo = $asignatura->apertura_campo == "Laboratorio" ? " (L)":"";
        $sigla = $asignatura->asignatura_sigla.$campo;
        $periodo = $this->asignaturas->periodoPorInscripcionId($inscripcionId);
        $gestion = $periodo->periodo_gestion;
        $periodo = $periodo->periodo_nombre;
        
        $eliminarAsignaturaInscrita = $this->asignaturas->eliminarAsignaturaInscrita($inscripcionId);
        if ($eliminarAsignaturaInscrita) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes - Inscripciones',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Eliminación de inscripción en la asignatura "'.$sigla.'" realizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return to_route('estudiante.inscripciones', [$periodo, $gestion])
                ->with("exito", 'Eliminación de inscripción en la asignatura "'.$sigla.'" REALIZADA CORRECTAMENTE.');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Estudiantes - Inscripciones',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error en la eliminación de inscripción en la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        return to_route('estudiante.inscripciones', [$periodo, $gestion])
            ->with("error", "Operación cancelada.");
     }
    
    public function boletaPdf(Request $request)
    {
        ini_set('memory_limit', '2048M');
        
        $options = new Options();
        $options->set('chroot', __DIR__);
        $options->set('isPhpEnabled', true); 

        $request->validate(['id' => 'required']);
        $periodoId = $request->input('id');
        
        $periodo = $this->asignaturas->periodo($periodoId);
        $gestion = $periodo->periodo_gestion;
        $periodo = $periodo->periodo_nombre;

        $datosContacto = $this->datosUsuariosAutenticados->informacionPersonalPorPersonaId($this->personaId);
        $estudiante = $this->plantel->estudiantePorPersonaId($this->personaId);
        $asignaturas = $this->asignaturas->asignaturasInscritasPorPersonaId($this->personaId, $periodo, $gestion);
        try {
            $vista =  View::make('usuario.estudiante.inscripciones-boleta-pdf', compact(
                'periodo', 'gestion', 'datosContacto', 'estudiante', 'asignaturas'
            ))->render();
            $pdf = PDF::loadHtml($vista, 'UTF-8')->setPaper('letter')->setWarnings(false);
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes - Inscripciones',
                $accion = 7,
                $resultado = 1,
                $descripcion = 'Exportar PDF de boleta de inscripción.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return $pdf->stream('testPDF.pdf', ['Attachment' => false]);
        } catch (\Throwable $th) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes - Inscripciones',
                $accion = 7,
                $resultado = 2,
                $descripcion = 'Error al exportar PDF de boleta de inscripción generado por "'.$th->getMessage().'"',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->with('error', 'Error al exportar PDF de boleta de inscripción.');
        }
    }
}
