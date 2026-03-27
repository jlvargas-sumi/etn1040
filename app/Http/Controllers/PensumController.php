<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\DatoAcademicoCarrera;

class PensumController extends Controller
{
    private $datosAcademicosCarrera;

    private $planEstudios = '2000';
    private $mencion = ['control'=>'Control', 'sistemas'=>'Sistemas de Computación', 'telecomunicaciones'=>'Telecomunicaciones'];

    public function __construct()
    {
        $this->datosAcademicosCarrera = new DatoAcademicoCarrera;
    }

    public function indice()
    {

        $pensumControl = $this->datosAcademicosCarrera->pensum($this->planEstudios, $this->mencion['control']);
        $pensumSistemas = $this->datosAcademicosCarrera->pensum($this->planEstudios, $this->mencion['sistemas']);
        $pensumTelecomunicaciones = $this->datosAcademicosCarrera->pensum($this->planEstudios, $this->mencion['telecomunicaciones']);
        
        return view('pensum', ['pensumControl' => $pensumControl, 'pensumSistemas' => $pensumSistemas, 'pensumTelecomunicaciones' => $pensumTelecomunicaciones]);
    }
}
