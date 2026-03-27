<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DatoAcademicoCarrera
{
    public function pensum($plan_estudios, $mencion)
    {
        $pensum = DB::table('plan_estudios')
        ->join('asignaturas', 'plan_estudio_id', '=', 'asignatura_plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
        ->join('vista_prerrequisitos', 'pensum_id', '=', 'vista_prerrequisito_pensum_id')
        ->select('semestre_numerico', 'asignatura_sigla', 
                DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED) AS asignatura_numero'),
                'asignatura_nombre', 'asignatura_teoria', 'asignatura_laboratorio', 'vista_prerrequisito_sigla')
        ->where('plan_estudio_nombre', '=', $plan_estudios)
        ->where('mencion_nombre', '=', $mencion)
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->get();
        
        return $pensum;

    }
}
