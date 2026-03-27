<?php

namespace App\Http\Controllers\Usuario\Administrador\Carrera;

use App\Http\Controllers\Controller;

use App\Models\Carrera;
use App\Models\PanelControl;

use Illuminate\Http\Request;

class AdministradorHorarioController extends Controller
{
    private $plantel;
    private $carrera;
    private $panelControl;

    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->carrera = new Carrera;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice()
    {
        $horarios = 1;
        return view('usuario.administrador.carrera.administrar-horarios', compact(
            'horarios'
        ));
    }
}
