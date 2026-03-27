<?php

namespace App\Http\Controllers\Usuario\Estudiante;

use App\Http\Controllers\Controller;

use App\Models\DatoUsuarioAutenticado;
use App\Models\Plantel;
use App\Models\Asignatura;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Controller
{
    private $plantel;
    private $asignaturas;
    private $panelControl;

    private $personaId;
    
    private $periodo;
    private $gestion;

    public function __construct()
    {
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
        $notas = $this->asignaturas->notasSemestrePorPersonaId($this->personaId, $periodo, $gestion);
        
        return view('usuario.estudiante.notas',
            compact(
                'periodo',
                'gestion',
                'estudiante',
                'notas'
            )
        );
    }
    public function buscarNotas(Request $request)
    {
        $request->validate(['periodo' => 'required']);
        $request->validate(['gestion' => 'required|integer']);

        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');

        return to_route('estudiante.notas', [$periodo, $gestion]);
    }
    public function detalle($aperturaId, $periodo = null, $gestion = null)
    {
        $verificarMiAperturaId = $this->asignaturas->verificarMiAperturaIdEstudiante($aperturaId, $this->personaId, $periodo, $gestion);
        if (!$verificarMiAperturaId) {
            return to_route('estudiante.notas', [$periodo, $gestion]);
        }
        $aperturas = $this->asignaturas->aperturasEstudiantePorPersonaAperturaId($this->personaId, $aperturaId);
        $asignatura = $this->asignaturas->asignaturaPorAperturaId($aperturaId);
        $inscritoTeoria = $this->asignaturas->estudianteInscritoMateria($this->personaId, $aperturaId);
        $aperturaIdLaboratorio = $this->asignaturas->aperturaLaboratorioPorAperturaId($aperturaId);
        $inscritoLaboratorio = $this->asignaturas->estudianteInscritoMateria($this->personaId, $aperturaIdLaboratorio);
        
        return view('usuario.estudiante.notas-detalle',
            compact(
                'periodo',
                'gestion',
                'aperturas',
                'asignatura',
                'aperturaId',
                'inscritoTeoria',
                'inscritoLaboratorio',
            )
        );
    }
}
