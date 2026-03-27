<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Publicacion;

use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    private $publicaciones;

    private $tipo = 'Convocatoria';
    private $estado = 1;

    public function __construct()
    {
        $this->publicaciones = new Publicacion;
    }

    public function indice()
    {
        $publicaciones = $this->publicaciones->publicacionesPorTipo($this->tipo, $this->estado);

        return view('convocatorias', compact('publicaciones'));
    }
}