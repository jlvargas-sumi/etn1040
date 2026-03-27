<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\HorarioGeneral;

class HorarioController extends Controller
{
    private $horariosGenerales;

    public function __construct()
    {
        $this->horariosGenerales = new HorarioGeneral;
    }

    public function indice()
    {
        $periodo = 1;//Controlado por Administrador y debe ser actualizado por periodo.
        $gestion = 2023;//Controlado por Administrador y debe ser actualizado por periodo.

        $horariosSemestres = $this->horariosGenerales->horarioSemestres($periodo, $gestion);
        $horariosAulas = $this->horariosGenerales->horariosAulas($periodo, $gestion);
        
        return view('horarios', ['horariosSemestres' => $horariosSemestres, 'horariosAulas' => $horariosAulas]);
    }
}
