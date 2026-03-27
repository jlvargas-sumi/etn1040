<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaAcademica extends Model
{
    use HasFactory;
    protected $table = 'notas';
    protected $primaryKey = 'nota_id';

    public $timestamps = false;

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
        ->get();
        
        return $pensum;

    }
    public function registrarNotas($request)
    {
        DB::beginTransaction();
        try {
            $campo = $request->input('campo');
            $tipoCatedra = $request->input('tipo_catedra');
            $notaPrincipalTeoria = $request->input('nota_principal_teoria');
            $notaSecundariaTeoria = $request->input('nota_secundaria_teoria');
            $notaPrincipalLaboratorio = $request->input('nota_principal_laboratorio');
            $notaSecundariaLaboratorio = $request->input('nota_secundaria_laboratorio');

            if (empty(!$notaPrincipalTeoria)) {
                foreach ($notaPrincipalTeoria as $inscripcionIdTeoria => $notas) {
                    $nota = [];
                    $nota["notaPrincipal"] = [];
                    $nota["notaSecundaria"] = [];

                    foreach ($notas as $key => $valor) {
                        $nota["notaPrincipal"][$key] = floatval($valor);
                    }

                    foreach ($notaSecundariaTeoria[$inscripcionIdTeoria] as $key => $valor) {
                        $nota["notaSecundaria"][$key] = floatval($valor);
                    }

                    $nota = json_encode($nota);

                    Inscripcion::where('inscripcion_id', $inscripcionIdTeoria)
                        ->update([
                            'inscripcion_nota_'.$tipoCatedra => $nota
                        ]);
                }
            }
            if (empty(!$notaPrincipalLaboratorio)) {
                foreach ($notaPrincipalLaboratorio as $inscripcionIdLaboratorio => $notas) {
                    $nota = [];
                    $nota["notaPrincipal"] = [];
                    $nota["notaSecundaria"] = [];

                    foreach ($notas as $key => $valor) {
                        $nota["notaPrincipal"][$key] = floatval($valor);
                    }

                    foreach ($notaSecundariaLaboratorio[$inscripcionIdLaboratorio] as $key => $valor) {
                        $nota["notaSecundaria"][$key] = floatval($valor);
                    }

                    $nota = json_encode($nota);

                    Inscripcion::where('inscripcion_id', $inscripcionIdLaboratorio)
                        ->update([
                            'inscripcion_nota_'.$tipoCatedra => $nota
                        ]);
                }
            }
            
            DB::commit();
            return true;
        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
}
