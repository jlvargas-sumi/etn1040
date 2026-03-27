<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Publicacion;

use Illuminate\Http\Request;

class AnuncioController extends Controller
{
    private $publicaciones;

    private $estado = 1;
    private $tipo;

    public function __construct()
    {
        $this->publicaciones = new Publicacion;
    }

    public function indice($pagina = null, $seleccionarParametro = null, $valorParametro = null)
    {
        $publicaciones = $this->publicaciones->anuncios($this->estado);
        
        return view('anuncios', compact('publicaciones'));
    }
}
