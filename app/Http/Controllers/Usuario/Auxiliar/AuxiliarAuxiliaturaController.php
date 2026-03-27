<?php

namespace App\Http\Controllers\Usuario\Auxiliar;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Plantel;
use App\Models\Asignatura;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuxiliarAuxiliaturaController extends Controller
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

        $auxiliar = $this->plantel->auxiliarPorPersonaId($this->personaId);
        $asignaturas = $this->asignaturas->asignaturasAuxiliaturaPorPersonaId($this->personaId, $periodo, $gestion);
        
        return view('usuario.auxiliar.auxiliaturas', compact('periodo', 'gestion', 'auxiliar', 'asignaturas'));
    }
    public function buscar(Request $request)
    {
        $request->validate([
            'periodo' => 'required', 
            'gestion' => 'required|integer'
        ]);

        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');

        return to_route('auxiliar.auxiliaturas', [$periodo, $gestion]);
    }
}
