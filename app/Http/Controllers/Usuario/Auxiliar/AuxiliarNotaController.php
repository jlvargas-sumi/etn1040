<?php

namespace App\Http\Controllers\Usuario\Auxiliar;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Plantel;
use App\Models\Asignatura;
use App\Models\NotaAcademica;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Dompdf\Options;

class AuxiliarNotaController extends Controller
{
    private $actividades;
    private $plantel;
    private $asignaturas;
    private $notas;
    private $panelControl;

    private $personaId;
    
    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->plantel = new Plantel;
        $this->asignaturas = new Asignatura;
        $this->notas = new NotaAcademica;
        $this->panelControl = new PanelControl;

        $this->personaId = Auth::User()->usuario_persona_id;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }
    public function indice($aperturaId, $periodo = null, $gestion = null)
    {
        $verificarMiAperturaId = $this->asignaturas->verificarMiAperturaIdAuxiliar($aperturaId, $this->personaId, $periodo, $gestion);
        if (!$verificarMiAperturaId) {
            return to_route('auxiliar.auxiliaturas', [$periodo, $gestion]);
        }

        $auxiliar = $this->plantel->auxiliarPorPersonaId($this->personaId);
        $asignatura = $this->asignaturas->asignaturaPorAperturaId($aperturaId);
        $aperturas = $this->asignaturas->aperturasAuxiliaturaPorPersonaAperturaId($this->personaId, $aperturaId);
        $inscritosTeoria = $this->asignaturas->estudiantesInscritosMateria($aperturaId);
        $aperturaIdLaboratorio = $this->asignaturas->aperturaLaboratorioPorAperturaId($aperturaId);
        $inscritosLaboratorio = $this->asignaturas->estudiantesInscritosMateria($aperturaIdLaboratorio);
        
        return view('usuario.auxiliar.notas',
            compact('asignatura', 'aperturas', 'auxiliar', 'inscritosTeoria', 'inscritosLaboratorio', 
            'aperturaId', 'periodo', 'gestion')
        );
    }
    public function registrar(Request $request)
    {
        $request->validate([
            'apertura_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $aperturaId = $request->input('apertura_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');
        
        $registrar = $this->notas->registrarNotas($request);
        if ($registrar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares - Notas',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Registro de notas de la asignatura "'.$sigla.'" realizado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Registro de notas de la asignatura "'.$sigla.'" REALIZADO CORRECTAMENTE.');
            return to_route('auxiliar.notas', [$aperturaId, $periodo, $gestion]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares - Notas',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error en el registro de notas de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('auxiliar.notas', [$aperturaId, $periodo, $gestion]);
    }
    public function exportarPdf(Request $request, $aperturaId, $periodo = null, $gestion = null)
    {
        ini_set('memory_limit', '2048M');
        
        $options = new Options();
        $options->set('chroot', __DIR__);
        $options->set('isPhpEnabled', true); 

        $verificarMiAperturaId = $this->asignaturas->verificarMiAperturaIdAuxiliar($aperturaId, $this->personaId, $periodo, $gestion);
        if (!$verificarMiAperturaId) {
            return to_route('auxiliar.notas', [$periodo, $gestion]);
        }

        $auxiliar = $this->plantel->auxiliarPorPersonaId($this->personaId);
        $asignatura = $this->asignaturas->asignaturaPorAperturaId($aperturaId);
        $aperturas = $this->asignaturas->aperturasAuxiliaturaPorPersonaAperturaId($this->personaId, $aperturaId);
        $inscritosTeoria = $this->asignaturas->estudiantesInscritosMateria($aperturaId);
        $aperturaIdLaboratorio = $this->asignaturas->aperturaLaboratorioPorAperturaId($aperturaId);
        $inscritosLaboratorio = $this->asignaturas->estudiantesInscritosMateria($aperturaIdLaboratorio);
        
        try {
            $vista =  View::make('usuario.auxiliar.notas-pdf', compact(
                'asignatura', 'aperturas', 'auxiliar', 'inscritosTeoria', 'inscritosLaboratorio',
                'aperturaId', 'periodo', 'gestion'
            ))->render();
            
            $pdf = PDF::loadHtml($vista, 'UTF-8')->setPaper('letter')->setWarnings(false);
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares - Notas',
                $accion = 7,
                $resultado = 1,
                $descripcion = 'Exportar PDF de notas de la asignatura "'.$asignatura->asignatura_sigla.'".',
                $request->ip(),
                $request->header('User-Agent')
            );
            return $pdf->stream('notasAuxPDF.pdf', ['Attachment' => false]);
        } catch (\Throwable $th) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares - Notas',
                $accion = 7,
                $resultado = 2,
                $descripcion = 'Error al exportar PDF de notas de la asignatura "'.$asignatura->asignatura_sigla.'" generado por "'.$th->getMessage().'"',
                $request->ip(),
                $request->header('User-Agent')
            );
            return back()->with('error', 'Error al exportar PDF de notas de la asignatura "'.$asignatura->asignatura_sigla.'".');
        }
    }
}
