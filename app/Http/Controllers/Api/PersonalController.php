<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\DatoUsuarioAutenticado;
use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;

class PersonalController extends Controller
{
    private $datosUsuariosAutenticados;
    private $plantel;
    private $panelControl;

    private $planEstudios;
    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
        $this->plantel = new Plantel;
        $this->panelControl = new PanelControl;

        $periodoActual = $this->panelControl->panelControlActual();

        $this->planEstudios = $periodoActual->plan_estudio_nombre;
        $this->periodo = $periodoActual->periodo_nombre;
        $this->gestion = $periodoActual->periodo_gestion;
    }
    public function datosPersonalPorCi($ci = null)
    {
        $datos = $this->datosUsuariosAutenticados->informacionPersonalPorCi($ci);
        
        $datos = response()->json($datos);
        return $datos;
    }
    public function datosEstudiantePorRu($ru = null)
    {
        $datos = $this->datosUsuariosAutenticados->informacionPersonalPorRu($ru);
        
        $datos = response()->json($datos);
        return $datos;
    }
}
