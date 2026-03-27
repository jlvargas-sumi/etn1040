<?php

namespace App\Http\Controllers\Usuario\Estudiante;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Plantel;
use App\Models\Asignatura;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Dompdf\Options;

class HorarioController extends Controller
{
    private $actividades;
    private $plantel;
    private $asignaturas;
    private $panelControl;

    private $personaId;
    
    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->plantel = new Plantel;
        $this->asignaturas = new Asignatura;
        $this->panelControl = new PanelControl;

        $this->personaId = Auth::User()->usuario_persona_id;
        
        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($periodo = null, $gestion = null)
    {
        $periodo = empty($periodo) ? $this->periodo:$periodo;
        $gestion = empty($gestion) ? $this->gestion:$gestion;

        $estudiante = $this->plantel->estudiantePorPersonaId($this->personaId);
        $horarios = $this->asignaturas->horariosSemestrePorPersonaId($this->personaId, $periodo, $gestion);
        
        return view('usuario.estudiante.horarios',
            compact(
                'periodo',
                'gestion',
                'estudiante',
                'horarios'
            )
        );
    }
    public function buscar(Request $request)
    {
        $request->validate(['periodo' => 'required']);
        $request->validate(['gestion' => 'required|integer']);

        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');

        return to_route('estudiante.horarios', [$periodo, $gestion]);
    }
    public function pdf(Request $request)
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

        $estudiante = $this->plantel->estudiantePorPersonaId($this->personaId);
        $horarios = $this->asignaturas->horariosSemestrePorPersonaId($this->personaId, $periodo, $gestion);
        try {
            $vista =  View::make('usuario.estudiante.horarios-pdf', compact(
                'periodo', 'gestion', 'estudiante', 'horarios'
            ))->render();
    
            $pdf = PDF::loadHtml($vista, 'UTF-8')->setPaper('letter', 'landscape')->setWarnings(false);
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes - Horarios',
                $accion = 7,
                $resultado = 1,
                $descripcion = 'Exportar PDF de horarios correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            return $pdf->stream('horariosPDF.pdf', ['Attachment' => false]);
        } catch (\Throwable $th) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Estudiantes - Horarios',
                $accion = 7,
                $resultado = 2,
                $descripcion = 'Error al exportar PDF de horarios generado por "'.$th->getMessage().'"',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->with('error', 'Error al exportar PDF de horarios.');
        }
    }
}
