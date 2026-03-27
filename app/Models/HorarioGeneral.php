<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class HorarioGeneral
{
    public function horarioSemestres($periodo, $gestion)
    {
        $horarioSemestres = DB::table('horarios_semestres')->
            join('periodos', 'horario_seme_periodo_id', '=', 'periodo_id')
            ->join('semestres', 'horario_seme_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'horario_seme_mencion_id', '=', 'mencion_id')
            ->where('periodo_nombre', $periodo)
            ->where('periodo_gestion', $gestion)
            ->orderBy('semestre_numerico')->get();
        return $horarioSemestres;
    }
    public function horariosAulas($periodo, $gestion)
    {
        $horariosAulas = DB::table('horarios_aulas')->
            join('periodos', 'horario_aula_periodo_id', '=', 'periodo_id')
            ->join('aulas', 'horario_aula_aula_id', '=', 'aula_id')
            ->where('periodo_nombre', $periodo)
            ->where('periodo_gestion', $gestion)
            ->orderBy('aula_nombre')->get();
        return $horariosAulas;
    }
}