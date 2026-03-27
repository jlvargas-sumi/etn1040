<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\DatoUsuarioAutenticado;
use App\Models\Plantel;
use App\Models\Carrera;
use App\Models\PanelControl;

use Illuminate\Http\Request;

class CarreraController extends Controller
{
    private $datosUsuariosAutenticados;
    private $plantel;
    private $carrera;
    private $asignaturas;
    private $panelControl;

    private $planEstudios;
    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
        $this->plantel = new Plantel;
        $this->carrera = new Carrera;
        $this->asignaturas = new Asignatura();
        $this->panelControl = new PanelControl;

        $periodoActual = $this->panelControl->panelControlActual();

        $this->planEstudios = $periodoActual->plan_estudio_nombre;
        $this->periodo = $periodoActual->periodo_nombre;
        $this->gestion = $periodoActual->periodo_gestion;
    }
    public function datosPensumPorAsignaturaCompleto($id = null)
    {
        $planEstudiosId = $this->asignaturas->planEstudiosIdPorAsignaturaId($id);
        $pensum = $this->asignaturas->pensumPorAsignaturaId($id);
        $semestres = $this->carrera->semestres();
        $asignaturas = $this->asignaturas->asignaturasPorPlanEstudiosId($planEstudiosId);
        $datos = response()->json(['pensum'=>$pensum, 'semestres'=>$semestres, 'asignaturas'=>$asignaturas]);
        return $datos;
    }
    // public function datosPensumPorAsignatura($id = null)
    // {
    //     $datos = $this->asignaturas->pensumPorAsignaturaId($id);
        
    //     $datos = response()->json($datos);
    //     return $datos;
    // }
}
