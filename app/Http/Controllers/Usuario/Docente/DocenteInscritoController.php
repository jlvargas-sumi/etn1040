<?php

namespace App\Http\Controllers\Usuario\Docente;

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

class DocenteInscritoController extends Controller
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

    public function indice($aperturaId, $periodo = null, $gestion = null)
    {
        $verificarMiAperturaId = $this->asignaturas->verificarMiAperturaIdDocente($aperturaId, $this->personaId, $periodo, $gestion);
        if (!$verificarMiAperturaId) {
            return to_route('docente.docencias', [$periodo, $gestion]);
        }

        $docente = $this->plantel->docentePorPersonaId($this->personaId);
        $asignatura = $this->asignaturas->asignaturaPorAperturaId($aperturaId);
        $inscritos = $this->asignaturas->estudiantesInscritosMateria($aperturaId);
        
        return view('usuario.docente.inscritos', 
            compact('asignatura', 'docente', 'inscritos', 'aperturaId', 'periodo', 'gestion')
        );
    }
    public function exportarPdf(Request $request, $aperturaId, $periodo = null, $gestion = null)
    {
        ini_set('memory_limit', '2048M');
        
        $options = new Options();
        $options->set('chroot', __DIR__);
        $options->set('isPhpEnabled', true); 

        $verificarMiAperturaId = $this->asignaturas->verificarMiAperturaIdDocente($aperturaId, $this->personaId, $periodo, $gestion);
        if (!$verificarMiAperturaId) {
            return to_route('docente.docencias', [$periodo, $gestion]);
        }

        $docente = $this->plantel->docentePorPersonaId($this->personaId);
        $asignatura = $this->asignaturas->asignaturaPorAperturaId($aperturaId);
        $inscritos = $this->asignaturas->estudiantesInscritosMateria($aperturaId);
        try {
            $vista =  View::make('usuario.docente.inscritos-pdf', compact(
                'asignatura', 'docente', 'inscritos', 'aperturaId', 'periodo', 'gestion'
            ))->render();
            $pdf = PDF::loadHtml($vista, 'UTF-8')->setPaper('letter')->setWarnings(false);
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes - Inscritos',
                $accion = 7,
                $resultado = 1,
                $descripcion = 'Exportar PDF de inscritos de la asignatura "'.$asignatura->asignatura_sigla.'".',
                $request->ip(),
                $request->header('User-Agent')
            );
            return $pdf->stream('Inscritos.pdf', ['Attachment' => false]);
        } catch (\Throwable $th) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes - Inscritos',
                $accion = 7,
                $resultado = 2,
                $descripcion = 'Error al exportar PDF de inscritos de la asignatura "'.$asignatura->asignatura_sigla.'" generado por "'.$th->getMessage().'"',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->with('error', 'Error al exportar PDF de inscritos de la asignatura "'.$asignatura->asignatura_sigla.'".');
        }
    }
}
