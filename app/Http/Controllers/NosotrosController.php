<?php

namespace App\Http\Controllers;

use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;

class NosotrosController extends Controller
{
    private $plantel;
    private $panelControl;
    private $gestion;
    private $periodo;
    private $estado = 1;

    public function __construct()
    {
        $this->plantel = new Plantel;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice()
    {
        $administrativos = $this->plantel->administrativos($this->estado);
        $docentes = $this->plantel->docentesPorGestion($this->gestion, $this->estado);
        $auxiliares = $this->plantel->auxiliaresPorGestion($this->gestion, $this->estado);
        return view('nosotros', ['administrativos' => $administrativos, 'docentes' => $docentes, 'auxiliares' => $auxiliares]);

    }
}
