<?php

namespace App\Models;

use GuzzleHttp\Promise\Is;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;
    protected $table = 'actividades';
    protected $primaryKey = 'actividad_id';

    public $timestamps = false;

    public function registrarActividad($usuarioId, $modulo, $accion, $resultado, $descripcion, $ip, $navegador)
    {
        $actividad = new Actividad();
        $actividad->actividad_usuario_id = $usuarioId;
        $actividad->actividad_modulo = $modulo;
        $actividad->actividad_accion = $accion;
        $actividad->actividad_resultado = $resultado;
        $actividad->actividad_descripcion = $descripcion;
        $actividad->actividad_fecha = now();
        $actividad->actividad_ip = $ip;
        $actividad->actividad_navegador = $navegador;
        $actividad->save();
    }
}
