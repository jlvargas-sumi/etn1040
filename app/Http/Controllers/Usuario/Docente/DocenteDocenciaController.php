<?php

namespace App\Http\Controllers\Usuario\Docente;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Auth\PerfilController;

use App\Models\DatoUsuarioAutenticado;
use App\Models\Plantel;
use App\Models\Asignatura;
use App\Models\PanelControl;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteDocenciaController extends Controller
{
    private $perfil;
    
    private $datosUsuariosAutenticados;
    private $plantel;
    private $asignaturas;
    private $panelControl;

    private $personaId;
    private $estadoDocente = 1;
    
    private $estadoInscripcion;
    private $planEstudios;
    private $periodo;
    private $gestion;

    public function __construct()
    {
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

        $docente = $this->plantel->docentePorPersonaId($this->personaId);
        $asignaturas = $this->asignaturas->asignaturasDocenciaPorPersonaId($this->personaId, $periodo, $gestion);
        
        return view('usuario.docente.docencias', compact('periodo', 'gestion', 'docente', 'asignaturas'));
    }
    public function buscar(Request $request)
    {
        $request->validate([
            'periodo' => 'required', 
            'gestion' => 'required|integer'
        ]);

        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');

        return to_route('docente.docencias', [$periodo, $gestion]);
    }
    
}
