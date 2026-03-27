<?php

namespace App\Models;

use GuzzleHttp\Promise\Is;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;
    protected $table = 'asignaturas';
    protected $primaryKey = 'asignatura_id';

    public $timestamps = false;

    public function historialAsignaturasPorPersonaId($personaId)
    {
        $asignaturasDocencia = DB::table('docentes')
        ->select('asignatura_sigla', 'asignatura_nombre', 'asignatura_teoria', 'asignatura_laboratorio', 'apertura_campo')
        ->distinct()
        ->join('docencias', 'docente_id', '=', 'docencia_docente_id')
        ->join('aperturas', 'docencia_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('docente_persona_id', $personaId)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc')
        ->get();
        
        return $asignaturasDocencia;
    }
    public function horariosSemestrePorPersonaId($personaId, $periodo, $gestion)
    {
        $auxiliaturasInscritas = DB::table('estudiantes as e')
        ->select(
            'periodo_id', // agregado para el control de horarios pdf
            'semestre_numerico',
            'asignatura_sigla',
            'asignatura_nombre',
            'apertura_id',
            'apertura_paralelo',
            'apertura_campo',
            DB::raw('"Auxiliatura" as clase'),
            'asignatura_teoria',
            'asignatura_laboratorio',
            'asignatura_id',
            'clase_auxiliatura_dia as dia',
            'clase_auxiliatura_hora_inicio as hora_inicio',
            'clase_auxiliatura_hora_fin as hora_fin',
            'aula_nombre',
             DB::raw("CONCAT('Aux.', persona_nombres, ' ', persona_primer_apellido, ' ', persona_segundo_apellido) as profesor")
            )
        ->distinct()
        ->join('inscripciones', 'e.estudiante_id', '=', 'inscripcion_estudiante_id')
        ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->join('auxiliaturas', 'apertura_id', '=', 'auxiliatura_apertura_id')
        ->join('clases_auxiliaturas', 'auxiliatura_id', '=', 'clase_auxiliatura_auxiliatura_id')
        ->join('aulas', 'clase_auxiliatura_aula_id', '=', 'aula_id')
        ->join('auxiliares', 'auxiliatura_auxiliar_id', '=', 'auxiliar_id')
        ->join('estudiantes as a', 'auxiliar_estudiante_id', '=', 'a.estudiante_id')
        ->join('personas', 'a.estudiante_persona_id', '=', 'persona_id')
        ->where('inscripcion_estado', 1)
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('e.estudiante_persona_id', $personaId)
        // ->whereIn('apertura_inscripcion', [0, 1])
        ->orderBy('dia')
        ->orderBy('hora_inicio')
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc');

        $docenciasInscritas = DB::table('estudiantes as e')
        ->select(
            'periodo_id', // agregado para el control de horarios pdf
            'semestre_numerico',
            'asignatura_sigla',
            'asignatura_nombre',
            'apertura_id',
            'apertura_paralelo',
            'apertura_campo',
            DB::raw('"Docencia" as clase'),
            'asignatura_teoria',
            'asignatura_laboratorio',
            'asignatura_id',
            'clase_docencia_dia as dia',
            'clase_docencia_hora_inicio as hora_inicio',
            'clase_docencia_hora_fin as hora_fin',
            'aula_nombre',
             DB::raw("CONCAT(docente_grado,' ', persona_nombres, ' ', persona_primer_apellido, ' ', persona_segundo_apellido) as profesor")
            )
        ->distinct()
        ->join('inscripciones', 'e.estudiante_id', '=', 'inscripcion_estudiante_id')
        ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->join('docencias', 'apertura_id', '=', 'docencia_apertura_id')
        ->join('clases_docencias', 'docencia_id', '=', 'clase_docencia_docencia_id')
        ->join('aulas', 'clase_docencia_aula_id', '=', 'aula_id')
        ->join('docentes', 'docencia_docente_id', '=', 'docente_id')
        ->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->where('inscripcion_estado', 1)
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('e.estudiante_persona_id', $personaId)
        // ->whereIn('apertura_inscripcion', [0, 1])
        ->orderBy('dia')
        ->orderBy('hora_inicio')
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc');
        
        $horarios = $auxiliaturasInscritas->union($docenciasInscritas)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        return $horarios;
    }
    public function notasSemestrePorPersonaId($personaId, $periodo, $gestion)
    {
        $asignaturasInscritas = DB::table('estudiantes')
        ->select('semestre_numerico', 'asignatura_sigla', 'asignatura_nombre', 'apertura_id', 'apertura_paralelo', 'apertura_campo', 'asignatura_teoria', 'asignatura_laboratorio', 'asignatura_id', 'inscripcion_fecha', 'nota_teoria')
        ->distinct()
        ->join('inscripciones', 'estudiante_id', '=', 'inscripcion_estudiante_id')
        ->leftjoin('notas', 'inscripcion_id', '=', 'nota_inscripcion_id')
        ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('inscripcion_estado', 1)
        //->where('nota_estado', 1)
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('estudiante_persona_id', $personaId)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc')
        ->get();
        
        return $asignaturasInscritas;
    }
    public function aperturasHabilitadasParaInscripcion($planEstudiosId, $mencionId, $periodo, $gestion)
    {
        $aperturas = DB::table('plan_estudios')
            ->join('asignaturas', 'plan_estudio_id', '=', 'asignatura_plan_estudio_id')
            ->join('aperturas', 'asignatura_id', '=', 'apertura_asignatura_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
            ->where('plan_estudio_id', $planEstudiosId)
            ->where('mencion_id', $mencionId == 0 ? 1:$mencionId)
            ->where('semestre_numerico', $mencionId == 0 ? '<=':'>=', $mencionId == 0 ? 6:7)
            ->where('periodo_nombre', $periodo)
            ->where('periodo_gestion', $gestion)
            // ->whereIn('apertura_inscripcion', [0, 1])
            ->orderBy('semestre_numerico')
            ->orderBy('asignatura_id')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->orderBy('apertura_campo', 'desc')
            ->orderBy('apertura_paralelo')
            ->get();

        // return $aperturas;
        $nuevaFila = [];
        $nuevaMatriz = [];
        foreach ($aperturas as $i => $apertura) {
            $array = [
                'asignaturaId'=>$apertura->asignatura_id, 
                'paralelo'=>$apertura->apertura_paralelo,
                'aperturaId'=>$apertura->apertura_id
            ];
            array_push($nuevaFila, $array);
            
            if ($i != count($aperturas)-1) {
                if (($apertura->asignatura_id.'-'.$apertura->apertura_inscripcion) != ($aperturas[$i+1]->asignatura_id.'-'.$aperturas[$i+1]->apertura_inscripcion)) {
                    array_push($nuevaMatriz, [
                        'paralelos'=>$nuevaFila, 
                        'gestion'=>$apertura->periodo_gestion,
                        'periodo'=>$apertura->periodo_nombre,
                        'mencion'=>$apertura->mencion_nombre,
                        'semestre'=>$apertura->semestre_literal,
                        'aperturaId'=>$apertura->apertura_id,
                        'asignaturaId'=>$apertura->asignatura_id,
                        'sigla'=>$apertura->asignatura_sigla,
                        'asignatura'=>$apertura->asignatura_nombre,
                        'campo'=>$apertura->apertura_campo,
                        'extraordinario'=>$apertura->apertura_extraordinario,
                        'inscripcion'=>$apertura->apertura_inscripcion,
                        'auxiliatura'=>$apertura->asignatura_auxiliatura,
                        'laboratorio'=>$apertura->asignatura_laboratorio,
                        'estado'=>$apertura->apertura_estado
                    ]);
                    $nuevaFila = [];
                }
            }
            else {   
                array_push($nuevaMatriz, [
                    'paralelos'=>$nuevaFila, 
                    'gestion'=>$apertura->periodo_gestion,
                    'periodo'=>$apertura->periodo_nombre,
                    'mencion'=>$apertura->mencion_nombre,
                    'semestre'=>$apertura->semestre_numerico,
                    'aperturaId'=>$apertura->apertura_id,
                    'asignaturaId'=>$apertura->asignatura_id,
                    'sigla'=>$apertura->asignatura_sigla,
                    'asignatura'=>$apertura->asignatura_nombre,
                    'campo'=>$apertura->apertura_campo,
                    'extraordinario'=>$apertura->apertura_extraordinario,
                    'inscripcion'=>$apertura->apertura_inscripcion,
                    'auxiliatura'=>$apertura->asignatura_auxiliatura,
                    'laboratorio'=>$apertura->asignatura_laboratorio,
                    'estado'=>$apertura->apertura_estado
                ]);
            } 
        }
        $aperturas = $nuevaMatriz;
        return $aperturas;
    }
    public function aperturasHabilitadasParaAuxiliaturas($planEstudiosId, $mencionId, $periodo, $gestion)
    {
        $aperturas = DB::table('plan_estudios')
            ->select('periodo_id', 'periodo_gestion', 'periodo_nombre', 'mencion_nombre', 'semestre_numerico', 'semestre_literal', 
                'asignatura_id', 'asignatura_sigla', 'asignatura_nombre', 'apertura_campo', 'apertura_extraordinario',
                'apertura_inscripcion', 'asignatura_auxiliatura', 'asignatura_laboratorio', 'apertura_estado')
            ->distinct()
            ->join('asignaturas', 'plan_estudio_id', '=', 'asignatura_plan_estudio_id')
            ->join('aperturas', 'asignatura_id', '=', 'apertura_asignatura_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
            ->where('plan_estudio_id', $planEstudiosId)
            ->where('mencion_id', $mencionId == 0 ? 1:$mencionId)
            ->where('semestre_numerico', $mencionId == 0 ? '<=':'>=', $mencionId == 0 ? 6:7)
            ->where('periodo_nombre', $periodo)
            ->where('periodo_gestion', $gestion)
            // ->where('asignatura_auxiliatura', 1)
            ->orderBy('semestre_numerico')
            ->orderBy('asignatura_id')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->orderBy('apertura_campo', 'desc')
            ->get();
        $nuevasClases = [];
        $nuevosGrupos = [];
        $nuevosParalelos = [];
        $nuevaMatriz = [];
        foreach ($aperturas as $i => $apertura) {
            $paralelos = Apertura::where('apertura_periodo_id', $apertura->periodo_id)
                ->where('apertura_asignatura_id', $apertura->asignatura_id)
                ->where('apertura_campo', $apertura->apertura_campo)
                ->get();
            foreach ($paralelos as $i => $paralelo) {
                $claseNulo[0] = [
                    'auxiliarId'=> null,
                    'aperturaId'=>$paralelo->apertura_id,
                    'grupo'=> null,
                    'clase'=> 1,
                    'dia'=> null,
                    'horaInicio'=> null,
                    'horaFin'=> null,
                    'aulaId'=> null
                ];
                $grupos = Auxiliatura::select('auxiliatura_auxiliar_id', 'auxiliatura_apertura_id', 'auxiliatura_grupo')
                    ->distinct()
                    ->where('auxiliatura_apertura_id', $paralelo->apertura_id)
                    ->orderBy('auxiliatura_grupo')
                    ->get();
                foreach ($grupos as $i => $grupo) {
                    $clases = Auxiliatura::join('clases_auxiliaturas', 'auxiliatura_id', '=', 'clase_auxiliatura_auxiliatura_id')
                        ->where('auxiliatura_apertura_id', $paralelo->apertura_id)
                        ->where('auxiliatura_grupo', $grupo->auxiliatura_grupo)
                        ->get();
                    foreach ($clases as $i => $clase) {
                        array_push($nuevasClases, [
                            'auxiliarId'=>$clase->auxiliatura_auxiliar_id,
                            'aperturaId'=>$clase->auxiliatura_apertura_id,
                            'grupo'=>$clase->auxiliatura_grupo,
                            'clase'=>$clase->clase_auxiliatura_numero,
                            'dia'=>$clase->clase_auxiliatura_dia,
                            'horaInicio'=>$clase->clase_auxiliatura_hora_inicio,
                            'horaFin'=>$clase->clase_auxiliatura_hora_fin,
                            'aulaId'=>$clase->clase_auxiliatura_aula_id,
                        ]);
                    }
                    $claseNulo[0] = [
                        'auxiliarId'=> null,
                        'aperturaId'=>$paralelo->apertura_id,
                        'grupo'=> $grupo->auxiliatura_grupo,
                        'clase'=> 1,
                        'dia'=> null,
                        'horaInicio'=> null,
                        'horaFin'=> null,
                        'aulaId'=> null
                    ];
                    array_push($nuevosGrupos, [
                        'clases'=>$nuevasClases == null ? $claseNulo:$nuevasClases,
                        'auxiliarId'=>$grupo->auxiliatura_auxiliar_id,
                        'aperturaId'=>$grupo->auxiliatura_apertura_id,
                        'grupo'=>$grupo->auxiliatura_grupo
                    ]);
                    $nuevasClases = [];
                }
                
                $grupoNulo[0] = [
                    'clases'=>$claseNulo,
                    'auxiliarId'=> null,
                    'aperturaId'=>$paralelo->apertura_id,
                    'grupo'=> 1
                ];
                array_push($nuevosParalelos, [
                    'grupos'=>$nuevosGrupos == null ? $grupoNulo:$nuevosGrupos,
                    'aperturaId'=>$paralelo->apertura_id,
                    'paralelo'=>$paralelo->apertura_paralelo
                ]);
                $nuevosGrupos = [];
            }

            array_push($nuevaMatriz, [
                'paralelos'=>$nuevosParalelos, 
                'gestion'=>$apertura->periodo_gestion,
                'periodo'=>$apertura->periodo_nombre,
                'mencion'=>$apertura->mencion_nombre,
                'semestre'=>$apertura->semestre_literal,
                'asignaturaId'=>$apertura->asignatura_id,
                'sigla'=>$apertura->asignatura_sigla,
                'asignatura'=>$apertura->asignatura_nombre,
                'campo'=>$apertura->apertura_campo,
                'extraordinario'=>$apertura->apertura_extraordinario,
                'inscripcion'=>$apertura->apertura_inscripcion,
                'auxiliatura'=>$apertura->asignatura_auxiliatura,
                'laboratorio'=>$apertura->asignatura_laboratorio,
                'estado'=>$apertura->apertura_estado
            ]);
            $nuevosParalelos = [];
        }
        return $nuevaMatriz;
        
    }
    public function actualizarAuxiliatura($request)
    {
        $aperturaId = $request->input('apertura_id');
        $grupo = $request->input('grupo');
        $auxiliarId = $request->input('auxiliar_id');
        $clases = $request->input('clases');
        $dias = $request->input('dias');
        $horasInicio = $request->input('horas_inicio');
        $horasFin = $request->input('horas_fin');
        $aulasId = $request->input('aulas_id');

        DB::beginTransaction();
        try {
            $auxiliaturas = Auxiliatura::where('auxiliatura_apertura_id', $aperturaId)
                ->where('auxiliatura_grupo', $grupo)
                ->first();
            if (empty($auxiliaturas)) {
                $datos = [
                    'auxiliatura_auxiliar_id' => $auxiliarId,
                    'auxiliatura_apertura_id' => $aperturaId,
                    'auxiliatura_grupo' => $grupo
                ];
                $auxiliaturaId = Auxiliatura::create($datos);
                $auxiliaturaId = $auxiliaturaId->auxiliatura_id;

                $datos = [
                    'clase_auxiliatura_auxiliatura_id' => $auxiliaturaId,
                    'clase_auxiliatura_numero' => $clases[0],
                    'clase_auxiliatura_dia' => $dias[0],
                    'clase_auxiliatura_hora_inicio' => $horasInicio[0],
                    'clase_auxiliatura_hora_fin' => $horasFin[0],
                    'clase_auxiliatura_aula_id' => $aulasId[0]
                ];
                ClaseAuxiliatura::create($datos);
            } else{
                foreach ($clases as $i => $clase) {
                    $auxiliaturaId = Auxiliatura::where('auxiliatura_apertura_id', $aperturaId)
                        ->where('auxiliatura_grupo', $grupo)
                        ->value('auxiliatura_id');

                    $datos = [
                        'auxiliatura_auxiliar_id' => $auxiliarId
                    ];
                    Auxiliatura::where('auxiliatura_id', $auxiliaturaId)
                        ->update($datos);

                    $datos = [
                        'clase_auxiliatura_dia' => $dias[$i],
                        'clase_auxiliatura_hora_inicio' => $horasInicio[$i],
                        'clase_auxiliatura_hora_fin' => $horasFin[$i],
                        'clase_auxiliatura_aula_id' => $aulasId[$i]
                    ];
                    ClaseAuxiliatura::where('clase_auxiliatura_auxiliatura_id', $auxiliaturaId)
                        ->where('clase_auxiliatura_numero', $clase)
                        ->update($datos);
                }
            }

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function crearGrupo($request)
    {
        $id = $request->input('id');
        $grupo = $request->input('grupo');

        DB::beginTransaction();
        try {
            $grupos = Auxiliatura::where('auxiliatura_apertura_id', $id)
                ->first();
            if (empty($grupos)) {
                $datos = [
                    'auxiliatura_apertura_id' => $id,
                    'auxiliatura_grupo' => 1
                ];
                $auxiliaturaId = Auxiliatura::create($datos);
                $auxiliaturaId = $auxiliaturaId->auxiliatura_id;
                $datos = [
                    'clase_auxiliatura_auxiliatura_id' => $auxiliaturaId
                ];
                ClaseAuxiliatura::create($datos);
            }

            $grupos = Auxiliatura::where('auxiliatura_apertura_id', $id)
                ->where('auxiliatura_grupo', $grupo)
                ->first();
            if (!empty($grupos)) {
                DB::rollback();
                return "Duplicado";
            }

            $datos = [
                'auxiliatura_apertura_id' => $id,
                'auxiliatura_grupo' => $grupo
            ];
            $auxiliaturaId = Auxiliatura::create($datos);
            $auxiliaturaId = $auxiliaturaId->auxiliatura_id;

            $datos = [
                'clase_auxiliatura_auxiliatura_id' => $auxiliaturaId
            ];
            ClaseAuxiliatura::create($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function actualizarGrupo($request)
    {
        $id = $request->input('id');
        $grupoActual = $request->input('grupo_actual');
        $grupo = $request->input('grupo');

        DB::beginTransaction();
        try {
            $grupos = Auxiliatura::where('auxiliatura_apertura_id', $id)
                ->where('auxiliatura_grupo', $grupo)
                ->first();
            if (!empty($grupos)) {
                DB::rollback();
                return "Duplicado";
            }

            $datos = [
                'auxiliatura_grupo' => $grupo
            ];
            Auxiliatura::where('auxiliatura_apertura_id', $id)
                ->where('auxiliatura_grupo', $grupoActual)
                ->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function eliminarGrupo($request)
    {
        $id = $request->input('id');
        $grupo = $request->input('grupo');

        DB::beginTransaction();
        try {
            Auxiliatura::where('auxiliatura_apertura_id', $id)
                ->where('auxiliatura_grupo', $grupo)
                ->delete();

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function aperturaPorId($id)
    {
        $apertura = Apertura::where('apertura_id', $id)->first();
        
        return $apertura;
    }
    public function aperturasHabilitadasParaDocencias($planEstudiosId, $mencionId, $periodo, $gestion)
    {
        $aperturas = DB::table('plan_estudios')
            ->select('periodo_id', 'periodo_gestion', 'periodo_nombre', 'mencion_nombre', 'semestre_numerico', 'semestre_literal', 
                'asignatura_id', 'asignatura_sigla', 'asignatura_nombre', 'apertura_campo', 'apertura_extraordinario',
                'apertura_inscripcion', 'asignatura_auxiliatura', 'asignatura_laboratorio', 'apertura_estado')
            ->distinct()
            ->join('asignaturas', 'plan_estudio_id', '=', 'asignatura_plan_estudio_id')
            ->join('aperturas', 'asignatura_id', '=', 'apertura_asignatura_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
            ->where('plan_estudio_id', $planEstudiosId)
            ->where('mencion_id', $mencionId == 0 ? 1:$mencionId)
            ->where('semestre_numerico', $mencionId == 0 ? '<=':'>=', $mencionId == 0 ? 6:7)
            ->where('periodo_nombre', $periodo)
            ->where('periodo_gestion', $gestion)
            ->orderBy('semestre_numerico')
            ->orderBy('asignatura_id')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->orderBy('apertura_campo', 'desc')
            ->get();
        $nuevasClases = [];
        $nuevosGrupos = [];
        $nuevosParalelos = [];
        $nuevaMatriz = [];
        foreach ($aperturas as $i => $apertura) {
            $paralelos = Apertura::where('apertura_periodo_id', $apertura->periodo_id)
                ->where('apertura_asignatura_id', $apertura->asignatura_id)
                ->where('apertura_campo', $apertura->apertura_campo)
                ->get();
            foreach ($paralelos as $i => $paralelo) {
                $claseNulo[0] = [
                    'docenteId'=> null,
                    'aperturaId'=>$paralelo->apertura_id,
                    'grupo'=> null,
                    'clase'=> 1,
                    'dia'=> null,
                    'horaInicio'=> null,
                    'horaFin'=> null,
                    'aulaId'=> null
                ];
                $claseNulo[1] = [
                    'docenteId'=> null,
                    'aperturaId'=>$paralelo->apertura_id,
                    'grupo'=> null,
                    'clase'=> 2,
                    'dia'=> null,
                    'horaInicio'=> null,
                    'horaFin'=> null,
                    'aulaId'=> null
                ];
                $grupos = Docencia::select('docencia_docente_id', 'docencia_apertura_id', 'docencia_grupo')
                    ->distinct()
                    ->where('docencia_apertura_id', $paralelo->apertura_id)
                    ->get();    
                foreach ($grupos as $i => $grupo) {
                    $clases = Docencia::join('clases_docencias', 'docencia_id', '=', 'clase_docencia_docencia_id')
                        ->where('docencia_apertura_id', $paralelo->apertura_id)
                        ->where('docencia_grupo', $grupo->docencia_grupo)
                        ->orderBy('clase_docencia_numero')
                        ->get();
                    foreach ($clases as $i => $clase) {
                        array_push($nuevasClases, [
                            'docenteId'=>$clase->docencia_docente_id,
                            'aperturaId'=>$clase->docencia_apertura_id,
                            'grupo'=>$clase->docencia_grupo,
                            'clase'=>$clase->clase_docencia_numero,
                            'dia'=>$clase->clase_docencia_dia,
                            'horaInicio'=>$clase->clase_docencia_hora_inicio,
                            'horaFin'=>$clase->clase_docencia_hora_fin,
                            'aulaId'=>$clase->clase_docencia_aula_id,
                        ]);
                    }
                    $claseNulo[0] = [
                        'docenteId'=> null,
                        'aperturaId'=>$paralelo->apertura_id,
                        'grupo'=> $grupo->docencia_grupo,
                        'clase'=> 1,
                        'dia'=> null,
                        'horaInicio'=> null,
                        'horaFin'=> null,
                        'aulaId'=> null
                    ];
                    $claseNulo[1] = [
                        'docenteId'=> null,
                        'aperturaId'=>$paralelo->apertura_id,
                        'grupo'=> $grupo->docencia_grupo,
                        'clase'=> 2,
                        'dia'=> null,
                        'horaInicio'=> null,
                        'horaFin'=> null,
                        'aulaId'=> null
                    ];
                    array_push($nuevosGrupos, [
                        'clases'=>$nuevasClases == null ? $claseNulo:$nuevasClases,
                        'docenteId'=>$grupo->docencia_docente_id,
                        'aperturaId'=>$grupo->docencia_apertura_id,
                        'grupo'=>$grupo->docencia_grupo
                    ]);
                    $nuevasClases = [];
                }
                
                $grupoNulo[0] = [
                    'clases'=>$claseNulo,
                    'docenteId'=> null,
                    'aperturaId'=>$paralelo->apertura_id,
                    'grupo'=> 1
                ];
                array_push($nuevosParalelos, [
                    'grupos'=>$nuevosGrupos == null ? $grupoNulo:$nuevosGrupos,
                    'aperturaId'=>$paralelo->apertura_id,
                    'paralelo'=>$paralelo->apertura_paralelo
                ]);
                $nuevosGrupos = [];
            }

            array_push($nuevaMatriz, [
                'paralelos'=>$nuevosParalelos, 
                'gestion'=>$apertura->periodo_gestion,
                'periodo'=>$apertura->periodo_nombre,
                'mencion'=>$apertura->mencion_nombre,
                'semestre'=>$apertura->semestre_literal,
                'asignaturaId'=>$apertura->asignatura_id,
                'sigla'=>$apertura->asignatura_sigla,
                'asignatura'=>$apertura->asignatura_nombre,
                'campo'=>$apertura->apertura_campo,
                'extraordinario'=>$apertura->apertura_extraordinario,
                'inscripcion'=>$apertura->apertura_inscripcion,
                'docencia'=>$apertura->asignatura_auxiliatura,
                'laboratorio'=>$apertura->asignatura_laboratorio,
                'estado'=>$apertura->apertura_estado
            ]);
            $nuevosParalelos = [];
        }
        return $nuevaMatriz;
        
    }
    public function actualizarDocencia($request)
    {
        $aperturaId = $request->input('apertura_id');
        $docenteId = $request->input('docente_id');
        $clases = $request->input('clases');
        $dias = $request->input('dias');
        $horasInicio = $request->input('horas_inicio');
        $horasFin = $request->input('horas_fin');
        $aulasId = $request->input('aulas_id');

        DB::beginTransaction();
        try {
            $docencias = Docencia::where('docencia_apertura_id', $aperturaId)
                ->first();
            if (empty($docencias)) {
                $datos = [
                    'docencia_docente_id' => $docenteId,
                    'docencia_apertura_id' => $aperturaId,
                ];
                $docenciaId = Docencia::create($datos);
                $docenciaId = $docenciaId->docencia_id;
                for ($i=0; $i < 2 ; $i++) { 
                    $datos = [
                        'clase_docencia_docencia_id' => $docenciaId,
                        'clase_docencia_numero' => $clases[$i],
                        'clase_docencia_dia' => $dias[$i],
                        'clase_docencia_hora_inicio' => $horasInicio[$i],
                        'clase_docencia_hora_fin' => $horasFin[$i],
                        'clase_docencia_aula_id' => $aulasId[$i]
                    ];
                    ClaseDocencia::create($datos);
                }
            } else{
                foreach ($clases as $i => $clase) {
                    $docenciaId = Docencia::where('docencia_apertura_id', $aperturaId)
                        ->value('docencia_id');

                    $datos = [
                        'docencia_docente_id' => $docenteId
                    ];
                    Docencia::where('docencia_id', $docenciaId)
                        ->update($datos);

                    $datos = [
                        'clase_docencia_dia' => $dias[$i],
                        'clase_docencia_hora_inicio' => $horasInicio[$i],
                        'clase_docencia_hora_fin' => $horasFin[$i],
                        'clase_docencia_aula_id' => $aulasId[$i]
                    ];
                    ClaseDocencia::where('clase_docencia_docencia_id', $docenciaId)
                        ->where('clase_docencia_numero', $clase)
                        ->update($datos);
                }
            }

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function crearClase($request)
    {
        $id = $request->input('id');
        $clase = $request->input('clase');

        DB::beginTransaction();
        try {
            $clases = Docencia::join('clases_docencias', 'docencia_id', '=', 'clase_docencia_docencia_id')
                ->where('docencia_apertura_id', $id)
                ->first();
            if (empty($clases)) {
                $datos = [
                    'docencia_apertura_id' => $id,
                ];
                $docenciaId = Docencia::create($datos);
                $docenciaId = $docenciaId->docencia_id;
                for ($i=0; $i < 2 ; $i++) { 
                    $datos = [
                        'clase_docencia_docencia_id' => $docenciaId,
                        'clase_docencia_numero' => $i+1
                    ];
                    ClaseDocencia::create($datos);
                }
            }

            $clases = Docencia::join('clases_docencias', 'docencia_id', '=', 'clase_docencia_docencia_id')
                ->where('docencia_apertura_id', $id)
                ->where('clase_docencia_numero', $clase)
                ->first();
            if (!empty($clases)) {
                DB::rollback();
                return "Duplicado";
            }

            $docenciaId = Docencia::where('docencia_apertura_id', $id)
                ->value('docencia_id');
                
            $datos = [
                'clase_docencia_docencia_id' => $docenciaId,
                'clase_docencia_numero' => $clase
            ];
            ClaseDocencia::create($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function actualizarClase($request)
    {
        $id = $request->input('id');
        $claseActual = $request->input('clase_actual');
        $clase = $request->input('clase');

        DB::beginTransaction();
        try {
            $clases = Docencia::join('clases_docencias', 'docencia_id', '=', 'clase_docencia_docencia_id')
                ->where('docencia_apertura_id', $id)
                ->where('clase_docencia_numero', $clase)
                ->first();
            if (!empty($clases)) {
                DB::rollback();
                return "Duplicado";
            }

            $docenciaId = Docencia::where('docencia_apertura_id', $id)
                ->value('docencia_id');

            $datos = [
                'clase_docencia_numero' => $clase
            ];
            ClaseDocencia::where('clase_docencia_docencia_id', $docenciaId)
                ->where('clase_docencia_numero', $claseActual)
                ->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function eliminarClase($request)
    {
        $id = $request->input('id');
        $clase = $request->input('clase');

        DB::beginTransaction();
        try {
            $docenciaId = Docencia::where('docencia_apertura_id', $id)
                ->value('docencia_id');
            ClaseDocencia::where('clase_docencia_docencia_id', $docenciaId)
                ->where('clase_docencia_numero', $clase)
                ->delete();

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function actualizarParalelo($request)
    {
        $id = $request->input('id');
        $paralelo = $request->input('paralelo');

        DB::beginTransaction();
        try {
            $datos = [
                'apertura_paralelo' => $paralelo
            ];
            Apertura::where('apertura_id', $id)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function eliminarParalelo($id)
    {
        // Condición para no eliminar si existen datos de secuencia
        DB::beginTransaction();
        try {
            Apertura::where('apertura_id', $id)->delete();

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function crearParalelo($request)
    {
        $id = $request->input('id');
        $paralelo = $request->input('paralelo');

        DB::beginTransaction();
        try {
            $apertura = Apertura::where('apertura_id', $id)->first();

            $periodoId = $apertura->apertura_periodo_id;
            $asignaturaId = $apertura->apertura_asignatura_id;
            $campo = $apertura->apertura_campo;
            $extraordinario = $apertura->apertura_extraordinario;
            $inscripcion = $apertura->apertura_inscripcion;

            $datos = [
                'apertura_periodo_id' => $periodoId,
                'apertura_asignatura_id' => $asignaturaId,
                'apertura_campo' => $campo,
                'apertura_extraordinario' => $extraordinario,
                'apertura_paralelo' => $paralelo,
                'apertura_inscripcion' => $inscripcion,
                'apertura_estado' => 1
            ];
            Apertura::create($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function LaboratorioIndependiente($id)
    {
        DB::beginTransaction();
        try {
            $apertura = Apertura::where('apertura_id', $id)->first();

            $periodoId = $apertura->apertura_periodo_id;
            $asignaturaId = $apertura->apertura_asignatura_id;
            $campo = $apertura->apertura_campo;
            $inscripcion = $apertura->apertura_inscripcion;

            $datos = [
                'apertura_inscripcion' => 1
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', '<>', $campo)
                ->update($datos);

            $datos = [
                'apertura_inscripcion' => 0
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', $campo)
                ->where('apertura_inscripcion', $inscripcion)
                ->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function LaboratorioDependiente($id)
    {
        DB::beginTransaction();
        try {
            $apertura = Apertura::where('apertura_id', $id)->first();

            $periodoId = $apertura->apertura_periodo_id;
            $asignaturaId = $apertura->apertura_asignatura_id;
            $campo = $apertura->apertura_campo;
            $inscripcion = $apertura->apertura_inscripcion;

            $datos = [
                'apertura_inscripcion' => 0
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', '<>', $campo)
                // ->where('apertura_inscripcion', $inscripcion)
                ->update($datos);

            $datos = [
                'apertura_inscripcion' => null
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', $campo)
                ->where('apertura_inscripcion', $inscripcion)
                ->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function crearLaboratorio($id)
    {
        DB::beginTransaction();
        try {
            $apertura = Apertura::where('apertura_id', $id)->first();

            $periodoId = $apertura->apertura_periodo_id;
            $asignaturaId = $apertura->apertura_asignatura_id;
            $campo = $apertura->apertura_campo;

            $datos = [
                'apertura_extraordinario' => 0
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', $campo)
                ->update($datos);
            
            $datos = [
                'apertura_periodo_id' => $periodoId,
                'apertura_asignatura_id' => $asignaturaId,
                'apertura_campo' => "Laboratorio",
                'apertura_extraordinario' => 1,
                'apertura_paralelo' => "A",
                'apertura_inscripcion' => null,
                'apertura_estado' => 1
            ];
            Apertura::create($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function eliminarLaboratorio($id)
    {
        // Condición para no eliminar si existen datos de secuencia
        DB::beginTransaction();
        try {
            $apertura = Apertura::where('apertura_id', $id)->first();

            $periodoId = $apertura->apertura_periodo_id;
            $asignaturaId = $apertura->apertura_asignatura_id;
            $campo = $apertura->apertura_campo;

            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', $campo)
                ->delete();

            $datos = [
                'apertura_extraordinario' => null,
                'apertura_inscripcion' => 0
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', '<>', $campo)
                ->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function habilitar($id)
    {
        DB::beginTransaction();
        try {
            $apertura = Apertura::where('apertura_id', $id)->first();

            $periodoId = $apertura->apertura_periodo_id;
            $asignaturaId = $apertura->apertura_asignatura_id;
            $campo = $apertura->apertura_campo;

            $datos = [
                'apertura_estado' => 1
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', $campo)
                ->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function deshabilitar($id)
    {
        DB::beginTransaction();
        try {
            $apertura = Apertura::where('apertura_id', $id)->first();

            $periodoId = $apertura->apertura_periodo_id;
            $asignaturaId = $apertura->apertura_asignatura_id;
            $campo = $apertura->apertura_campo;

            $datos = [
                'apertura_estado' => 0
            ];
            Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_campo', $campo)
                ->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function mencionesPorPlanEstudiosId($planEstudiosId)
    {
        $menciones = DB::table('menciones')->select('mencion_id', 'mencion_nombre', 'mencion_proteccion')
        ->distinct()
        ->join('pensum', 'mencion_id', '=', 'pensum_mencion_id')
        ->join('asignaturas', 'pensum_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->where('plan_estudio_id', $planEstudiosId)
        ->orderBy('mencion_id')
        ->get();

        return $menciones;
    }
    public function asignaturaPorId($id)
    {
        $asignatura = Asignatura::where('asignatura_id', $id)->first();
        return $asignatura;
    }
    public function crearAsignatura($request)
    {
        $planEstudiosId = $request->input('plan_estudios_id');
        $sigla = $request->input('sigla');
        $asignatura = $request->input('asignatura');
        $_mencionesId = $request->input('menciones_id');
        $semestresId = $request->input('semestres_id');

        $asignaturasIdPrerrequisito = $request->input('asignaturas_id_prerrequisito');
        $comentariosPrerrequisito = $request->input('comentarios_prerrequisito');
        $prerrequisitos = $request->input('prerrequisitos');

        $laboratorio = empty($request->input('laboratorio')) ? 0:1 ;
        $auxiliatura = empty($request->input('auxiliatura')) ? 0:1 ;

        DB::beginTransaction();
        try {
            $datos = [
                'asignatura_plan_estudio_id' => $planEstudiosId,
                'asignatura_sigla' => $sigla,
                'asignatura_nombre' => $asignatura,
                'asignatura_teoria' => 1,
                'asignatura_laboratorio' => $laboratorio,
                'asignatura_auxiliatura' => $auxiliatura
            ];
            $asignaturaId = Asignatura::create($datos);
            $asignaturaId = $asignaturaId->asignatura_id;
            
            $mencionesId = $this->mencionesPorPlanEstudiosId($planEstudiosId);
            foreach ($mencionesId as $mencionId) {
                $id = $mencionId->mencion_id;
                if (!empty($_mencionesId[$id])) {
                    $datos = [
                        'pensum_asignatura_id' => $asignaturaId,
                        'pensum_semestre_id' => $semestresId[$id],
                        'pensum_mencion_id' => $id
                    ];
                    $pensumId = Pensum::create($datos);
                    $pensumId = $pensumId->pensum_id;
                    if (isset($prerrequisitos[$id])) {
                        $asignaturaIdPrerrequisito = null;
                        $comentarioPrerrequisito = $comentariosPrerrequisito[$id];
                    } else{
                        $asignaturaIdPrerrequisito = $asignaturasIdPrerrequisito[$id];
                        $comentarioPrerrequisito = null;
                    }
                    $datos = [
                        'prerrequisito_pensum_id' => $pensumId,
                        'prerrequisito_asignatura_id' => $asignaturaIdPrerrequisito,
                        'prerrequisito_comentario' => $comentarioPrerrequisito
                    ];
                    DB::table('prerrequisitos')->insert($datos);
                }
            }

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function agregarAsignatura($request)
    {
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $asignaturaId = $request->input('asignatura_id');
        $semestreId = $request->input('semestre_id');

        $asignaturaIdPrerrequisito = $request->input('asignatura_id_prerrequisito');
        $comentarioPrerrequisito = $request->input('comentario_prerrequisito');
        $prerrequisito = $request->input('prerrequisito');

        DB::beginTransaction();
        try {            
            $datos = [
                'pensum_asignatura_id' => $asignaturaId,
                'pensum_semestre_id' => $semestreId,
                'pensum_mencion_id' => $mencionId
            ];
            $pensumId = Pensum::create($datos);
            $pensumId = $pensumId->pensum_id;
            
            if (!empty($prerrequisito)) {
                $asignaturaIdPrerrequisito = null;
                $comentarioPrerrequisito = $comentarioPrerrequisito;
            } else{
                $asignaturaIdPrerrequisito = $asignaturaIdPrerrequisito;
                $comentarioPrerrequisito = null;
            }
            $datos = [
                'prerrequisito_pensum_id' => $pensumId,
                'prerrequisito_asignatura_id' => $asignaturaIdPrerrequisito,
                'prerrequisito_comentario' => $comentarioPrerrequisito
            ];
            DB::table('prerrequisitos')->insert($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function actualizarAsignatura($request)
    {
        $asignaturaId = $request->input('id');
        $planEstudiosId = $request->input('plan_estudios_id');
        $mencionId = $request->input('mencion_id');
        $sigla = $request->input('sigla');
        $asignatura = $request->input('asignatura');

        $semestresId = $request->input('semestres_id');

        $asignaturasIdPrerrequisito = $request->input('asignaturas_id_prerrequisito');
        $comentariosPrerrequisito = $request->input('comentarios_prerrequisito');
        $prerrequisitos = $request->input('prerrequisitos');

        $laboratorio = empty($request->input('laboratorio')) ? 0:1 ;
        $auxiliatura = empty($request->input('auxiliatura')) ? 0:1 ;

        DB::beginTransaction();
        try {
            $datos = [
                'asignatura_plan_estudio_id' => $planEstudiosId,
                'asignatura_sigla' => $sigla,
                'asignatura_nombre' => $asignatura,
                'asignatura_teoria' => 1,
                'asignatura_laboratorio' => $laboratorio,
                'asignatura_auxiliatura' => $auxiliatura
            ];
            Asignatura::where('asignatura_id', $asignaturaId)->update($datos);
            
            $mencionesId = $this->mencionesPorPlanEstudiosId($planEstudiosId);
            foreach ($semestresId as $mencionId => $semestreId) {
                $pensumId = Pensum::select('pensum_id')
                    ->where('pensum_asignatura_id', $asignaturaId)
                    ->where('pensum_mencion_id', $mencionId)
                    ->value('pensum_id');

                $datos = [
                    'pensum_semestre_id' => $semestreId
                ];
                Pensum::where('pensum_id', $pensumId)->update($datos);
                    
                if (isset($prerrequisitos[$mencionId])) {
                    $asignaturaIdPrerrequisito = null;
                    $comentarioPrerrequisito = $comentariosPrerrequisito[$mencionId];
                } else{
                    $asignaturaIdPrerrequisito = $asignaturasIdPrerrequisito[$mencionId];
                    $comentarioPrerrequisito = null;
                }
                $datos = [
                    'prerrequisito_asignatura_id' => $asignaturaIdPrerrequisito,
                    'prerrequisito_comentario' => $comentarioPrerrequisito
                ];
                DB::table('prerrequisitos')->where('prerrequisito_pensum_id', $pensumId)->update($datos);
            }

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function eliminarAsignatura($request)
    {
        $id = $request->input('id');
        $eliminacionMasiva = $request->input('eliminacion_masiva');
        $mencionId = $request->input('mencion_id');
        DB::beginTransaction();
        try {
            if (empty($eliminacionMasiva)) {
                $pensum = Pensum::select('pensum_id')->where('pensum_asignatura_id', $id)->get();
                if (count($pensum) > 1) {
                    Pensum::where('pensum_asignatura_id', $id)
                        ->where('pensum_mencion_id', $mencionId)
                        ->delete();
                } else {
                    Asignatura::where('asignatura_id', $id)->delete();
                }
            } else {
                Asignatura::where('asignatura_id', $id)->delete();
            }

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function asignaturasInscritasPorPersonaId($personaId, $periodo, $gestion)
    {
        $asignaturasInscritas = DB::table('estudiantes')
        ->select('semestre_numerico', 'asignatura_sigla', 'asignatura_nombre', 'apertura_paralelo', 'apertura_campo', 'asignatura_teoria', 'asignatura_laboratorio', 'asignatura_id', 'inscripcion_id', 'inscripcion_fecha', 'periodo_id')
        ->distinct()
        ->join('inscripciones', 'estudiante_id', '=', 'inscripcion_estudiante_id')
        ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('inscripcion_estado', 1)
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('estudiante_persona_id', $personaId)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc')
        ->get();
        
        return $asignaturasInscritas;
    }
    public function asignaturasHabilitadasParaInscripcion($estudianteId, $planEstudios, $periodo, $gestion)
    {
        $asignaturasHabilitadasParaInscripcion = DB::table('aperturas')
        ->select('semestre_numerico', 'asignatura_sigla', 'asignatura_nombre', 'apertura_campo', 'asignatura_teoria', 'asignatura_laboratorio', 'asignatura_id', 'apertura_inscripcion')
        ->distinct()
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->whereNotIn(DB::raw("CONCAT(apertura_asignatura_id, '_', apertura_inscripcion)"), function ($query) use ($estudianteId, $periodo, $gestion) {
            $query->select(DB::raw("CONCAT(vista_apertura_asignatura_id, '_', vista_apertura_inscripcion)"))
                ->from('vista_inscripciones')
                ->where('vista_estudiante_id', $estudianteId)
                ->where('vista_periodo_nombre', $periodo)
                ->where('vista_periodo_gestion', $gestion);
        })
        ->where('plan_estudio_nombre', $planEstudios)
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->where('apertura_estado', 1)
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc')
        ->get();
        return $asignaturasHabilitadasParaInscripcion;
    }
    public function asignaturasRecortadasPorPlanEstudiosMencionId($planEstudiosId, $mencionId)
    {
        $asignaturas = Asignatura::join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->leftjoin('vista_prerrequisitos_nombres', 'pensum_id', '=', 'vista_pensum_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
            ->where('plan_estudio_id', $planEstudiosId)
            ->where('mencion_id', $mencionId == 0 ? 1:$mencionId)
            ->where('semestre_numerico', $mencionId == 0 ? '<=':'>=', $mencionId == 0 ? 6:7)
            ->orderBy('semestre_numerico')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->get();
        return $asignaturas;
    }
    public function asignaturasPorPlanEstudiosMencionId($planEstudiosId, $mencionId)
    {
        $asignaturas = Asignatura::join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->leftjoin('vista_prerrequisitos_nombres', 'pensum_id', '=', 'vista_pensum_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
            ->where('plan_estudio_id', $planEstudiosId)
            ->where('mencion_id', $mencionId)
            ->orderBy('semestre_numerico')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->get();
        return $asignaturas;
    }
    public function asignaturasPorPlanEstudiosId($planEstudiosId)
    {
        $asignaturas = Asignatura::select('asignatura_id', 'asignatura_sigla', 'asignatura_nombre', 'semestre_id', 'semestre_numerico', 'semestre_literal', 'semestre_ordinal' )
            ->distinct()
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->leftjoin('vista_prerrequisitos_nombres', 'pensum_id', '=', 'vista_pensum_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
            ->where('plan_estudio_id', $planEstudiosId)
            ->orderBy('semestre_numerico')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->get();
        return $asignaturas;
    }
    public function planEstudiosIdPorAsignaturaId($id)
    {
        $id = Asignatura::select('asignatura_plan_estudio_id')->where('asignatura_id', $id)->value('asignatura_plan_estudio_id');
        return $id;
    }
    public function pensumPorAsignaturaId($id)
    {
        $asignaturas = Asignatura::select()
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->join('menciones', 'pensum_mencion_id', '=', 'mencion_id')
            ->leftjoin('vista_prerrequisitos_nombres', 'pensum_id', '=', 'vista_pensum_id')
            ->where('asignatura_id', $id)
            ->orderBy('mencion_nombre')
            ->orderBy('semestre_numerico')
            ->orderBy('asignatura_sigla')
            ->get();
        return $asignaturas;
    }
    public function asignaturasAuxiliaturaPorPersonaId($personaId, $periodo, $gestion)
    {
        $asignaturasAuxiliatura = DB::table('estudiantes')
        ->select('semestre_numerico', 'asignatura_sigla', 'asignatura_nombre', 'apertura_id', 'apertura_paralelo', 'apertura_campo', 'asignatura_teoria', 'asignatura_laboratorio', 'asignatura_id')
        ->distinct()
        ->join('auxiliares', 'estudiante_id', '=', 'auxiliar_estudiante_id')
        ->join('auxiliaturas', 'auxiliar_id', '=', 'auxiliatura_auxiliar_id')
        ->join('aperturas', 'auxiliatura_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('estudiante_persona_id', $personaId)
        // ->whereIn('apertura_inscripcion', [0, 1])
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc')
        ->get();
        
        return $asignaturasAuxiliatura;
    }
    public function asignaturasDocenciaPorPersonaId($personaId, $periodo, $gestion)
    {
        $asignaturasDocencia = DB::table('docentes')
        ->select('semestre_numerico', 'asignatura_sigla', 'asignatura_nombre', 'apertura_id', 'apertura_paralelo', 'apertura_campo', 'asignatura_teoria', 'asignatura_laboratorio', 'asignatura_id')
        ->distinct()
        ->join('docencias', 'docente_id', '=', 'docencia_docente_id')
        ->join('aperturas', 'docencia_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('docente_persona_id', $personaId)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->orderBy('semestre_numerico')
        ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
        ->orderBy('asignatura_sigla')
        ->orderBy('apertura_campo', 'desc')
        ->get();
        
        return $asignaturasDocencia;
    }
    public function verificarMiAperturaIdDocente($aperturaId, $personaId, $periodo, $gestion)
    {
        $misAperturasId = DB::table('docentes')
        ->select('apertura_id')
        ->distinct()
        ->join('docencias', 'docente_id', '=', 'docencia_docente_id')
        ->join('aperturas', 'docencia_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('docente_persona_id', $personaId)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->pluck('apertura_id')
        ->toArray();
        
        if (in_array(intval($aperturaId), $misAperturasId, true)) {
            return true;
        } else{
            return false;
        }
    }
    public function verificarMiAperturaIdAuxiliar($aperturaId, $personaId, $periodo, $gestion)
    {
        $misAperturasId = DB::table('estudiantes')
        ->select('apertura_id')
        ->distinct()
        ->join('auxiliares', 'estudiante_id', '=', 'auxiliar_estudiante_id')
        ->join('auxiliaturas', 'auxiliar_id', '=', 'auxiliatura_auxiliar_id')
        ->join('aperturas', 'auxiliatura_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('estudiante_persona_id', $personaId)
        // ->whereIn('apertura_inscripcion', [0, 1])
        ->pluck('apertura_id')
        ->toArray();
        
        if (in_array(intval($aperturaId), $misAperturasId, true)) {
            return true;
        } else{
            return false;
        }
    }
    public function verificarMiAperturaIdEstudiante($aperturaId, $personaId, $periodo, $gestion)
    {
        $misAperturasId = DB::table('estudiantes')
        ->select('apertura_id')
        ->distinct()
        ->join('inscripciones', 'estudiante_id', '=', 'inscripcion_estudiante_id')
        ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
        ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->where('estudiante_persona_id', $personaId)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->pluck('apertura_id')
        ->toArray();
        
        if (in_array(intval($aperturaId), $misAperturasId, true)) {
            return true;
        } else{
            return false;
        }
    }
    public function aperturasDocenciaPorPersonaAperturaId($personaId, $aperturaId)
    {
        $misAperturasId = [];
        $apertura = Apertura::where('apertura_id', $aperturaId)->first();
        $periodoId = $apertura->apertura_periodo_id;
        $asignaturaId = $apertura->apertura_asignatura_id;
        $paralelo = $apertura->apertura_paralelo;
        $campo = $apertura->apertura_campo;
        if (mb_strtoupper($campo, "UTF-8") == "TEORÍA") {
            $aperturaLabo = Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_paralelo', $paralelo)
                ->where('apertura_campo', 'Laboratorio')
                ->first();
            if (!empty($aperturaLabo)) {
                array_push($misAperturasId, $aperturaLabo->apertura_id);
            }
        }
        array_push($misAperturasId, $aperturaId);

        $asignaturasDocencia = DB::table('docentes')
            ->select(
                'semestre_numerico', 
                'asignatura_sigla', 
                'asignatura_nombre', 
                'apertura_id', 
                'apertura_paralelo', 
                'apertura_campo', 
                'asignatura_teoria', 
                'asignatura_laboratorio', 
                'asignatura_id', 
                'apertura_inscripcion', 
                'docencia_id',
                'docencia_ponderacion'
            )
            ->distinct()
            ->join('docencias', 'docente_id', '=', 'docencia_docente_id')
            ->join('aperturas', 'docencia_apertura_id', '=', 'apertura_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->whereIn('apertura_id', $misAperturasId)
            ->where('asignatura_id', $asignaturaId)
            ->where('periodo_id', $periodoId)
            ->where('docente_persona_id', $personaId)
            ->orderBy('semestre_numerico')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->orderBy('apertura_campo', 'desc')
            ->get();

        $asignaturasDocencia->transform(function ($ponderacion) {
            $ponderacion->docencia_ponderacion = json_decode($ponderacion->docencia_ponderacion, true);
            return $ponderacion;
        });
            
        return $asignaturasDocencia;
    }
    public function aperturasAuxiliaturaPorPersonaAperturaId($personaId, $aperturaId)
    {
        $misAperturasId = [];
        $apertura = Apertura::where('apertura_id', $aperturaId)->first();
        $periodoId = $apertura->apertura_periodo_id;
        $asignaturaId = $apertura->apertura_asignatura_id;
        $paralelo = $apertura->apertura_paralelo;
        $campo = $apertura->apertura_campo;
        if (mb_strtoupper($campo, "UTF-8") == "TEORÍA") {
            $aperturaLabo = Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_paralelo', $paralelo)
                ->where('apertura_campo', 'Laboratorio')
                ->first();
            if (!empty($aperturaLabo)) {
                array_push($misAperturasId, $aperturaLabo->apertura_id);
            }
        }
        array_push($misAperturasId, $aperturaId);

        $asignaturasDocencia = DB::table('estudiantes')
            ->select(
                'semestre_numerico', 
                'asignatura_sigla', 
                'asignatura_nombre', 
                'apertura_id', 
                'apertura_paralelo', 
                'apertura_campo', 
                'asignatura_teoria', 
                'asignatura_laboratorio', 
                'asignatura_id', 
                'apertura_inscripcion', 
                'auxiliatura_id',
                'auxiliatura_ponderacion'
            )
            ->distinct()
            ->join('auxiliares', 'estudiante_id', '=', 'auxiliar_estudiante_id')
            ->join('auxiliaturas', 'auxiliar_id', '=', 'auxiliatura_auxiliar_id')
            ->join('aperturas', 'auxiliatura_apertura_id', '=', 'apertura_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->whereIn('apertura_id', $misAperturasId)
            ->where('asignatura_id', $asignaturaId)
            ->where('periodo_id', $periodoId)
            ->where('estudiante_persona_id', $personaId)
            ->orderBy('semestre_numerico')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->orderBy('apertura_campo', 'desc')
            ->get();

        $asignaturasDocencia->transform(function ($ponderacion) {
            $ponderacion->auxiliatura_ponderacion = json_decode($ponderacion->auxiliatura_ponderacion, true);
            return $ponderacion;
        });
            
        return $asignaturasDocencia;
    }
    public function aperturasEstudiantePorPersonaAperturaId($personaId, $aperturaId)
    {
        $misAperturasId = [];
        $apertura = Apertura::where('apertura_id', $aperturaId)->first();
        $periodoId = $apertura->apertura_periodo_id;
        $asignaturaId = $apertura->apertura_asignatura_id;
        $paralelo = $apertura->apertura_paralelo;
        $campo = $apertura->apertura_campo;
        if (mb_strtoupper($campo, "UTF-8") == "TEORÍA") {
            $aperturaLabo = Apertura::where('apertura_periodo_id', $periodoId)
                ->where('apertura_asignatura_id', $asignaturaId)
                ->where('apertura_paralelo', $paralelo)
                ->where('apertura_campo', 'Laboratorio')
                ->first();
            if (!empty($aperturaLabo)) {
                array_push($misAperturasId, $aperturaLabo->apertura_id);
            }
        }
        array_push($misAperturasId, $aperturaId);

        $asignaturasDocenciaEstudiante = DB::table('estudiantes')
            ->select(
                'semestre_numerico', 
                'asignatura_sigla', 
                'asignatura_nombre', 
                'apertura_id', 
                'apertura_paralelo', 
                'apertura_campo', 
                'asignatura_teoria', 
                'asignatura_laboratorio', 
                'asignatura_id', 
                'apertura_inscripcion', 
                'docencia_id as catedra_id',
                'docencia_ponderacion as ponderacion',
                DB::raw("'Docencia' as catedra"),
                'docentes.docente_grado as grado',
                'personas.*', 
            )
            ->distinct()
            ->join('inscripciones', 'inscripcion_estudiante_id', '=', 'estudiante_id')
            ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
            ->join('docencias', 'apertura_id', '=', 'docencia_apertura_id')
            ->join('docentes', 'docencia_docente_id', '=', 'docente_id')
            ->join('personas', 'docente_persona_id', '=', 'persona_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->whereIn('apertura_id', $misAperturasId)
            ->where('asignatura_id', $asignaturaId)
            ->where('periodo_id', $periodoId)
            ->where('estudiante_persona_id', $personaId)
            ->orderBy('semestre_numerico')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->orderBy('apertura_campo', 'desc')
            ->get();

        $asignaturasDocenciaEstudiante->transform(function ($ponderacion) {
            $ponderacion->ponderacion = json_decode($ponderacion->ponderacion, true);
            return $ponderacion;
        });
        
        $asignaturasAuxiliaturaEstudiante = DB::table('estudiantes as e1')
            ->select(
                'semestre_numerico', 
                'asignatura_sigla', 
                'asignatura_nombre', 
                'apertura_id', 
                'apertura_paralelo', 
                'apertura_campo', 
                'asignatura_teoria', 
                'asignatura_laboratorio', 
                'asignatura_id', 
                'apertura_inscripcion', 
                'auxiliatura_id as catedra_id',
                'auxiliatura_ponderacion as ponderacion',
                DB::raw("'Auxiliatura' as catedra"),
                DB::raw("'Aux. Univ.' as grado"),
                'personas.*', 
            )
            ->distinct()
            ->join('inscripciones', 'inscripcion_estudiante_id', '=', 'e1.estudiante_id')
            ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
            ->join('auxiliaturas', 'apertura_id', '=', 'auxiliatura_apertura_id')
            ->join('auxiliares', 'auxiliatura_auxiliar_id', '=', 'auxiliar_id')
            ->join('estudiantes as e2', 'auxiliar_estudiante_id', '=', 'e2.estudiante_id')
            ->join('personas', 'e2.estudiante_persona_id', '=', 'persona_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
            ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
            ->whereIn('apertura_id', $misAperturasId)
            ->where('asignatura_id', $asignaturaId)
            ->where('periodo_id', $periodoId)
            ->where('e1.estudiante_persona_id', $personaId)
            ->orderBy('semestre_numerico')
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
            ->orderBy('asignatura_sigla')
            ->orderBy('apertura_campo', 'desc')
            ->get();

        $asignaturasAuxiliaturaEstudiante->transform(function ($ponderacion) {
            $ponderacion->ponderacion = json_decode($ponderacion->ponderacion, true);
            return $ponderacion;
        });
            
        $unidos = $asignaturasDocenciaEstudiante->concat($asignaturasAuxiliaturaEstudiante);

        // Convierte a array para ordenar fácilmente
        $unidosArray = $unidos->toArray();

        // Ordena por apertura_campo y catedra
        usort($unidosArray, function($a, $b) {
            // Ordenar apertura_campo descendente
            $cmp = strcmp($b->apertura_campo, $a->apertura_campo);
            if ($cmp === 0) {
                // Si son iguales, ordenar catedra descendente
                return strcmp($b->catedra, $a->catedra);
            }
            return $cmp;
        });

        // devolverlo como colección de Laravel
        $unidosOrdenados = collect($unidosArray);

        return $unidosOrdenados;
    }
    // public function aperturasEstudiantePorPersonaAperturaId($personaId, $aperturaId, $docencia = true)
    // {
    //     $misAperturasId = [];
    //     $apertura = Apertura::where('apertura_id', $aperturaId)->first();
    //     $periodoId = $apertura->apertura_periodo_id;
    //     $asignaturaId = $apertura->apertura_asignatura_id;
    //     $paralelo = $apertura->apertura_paralelo;
    //     $campo = $apertura->apertura_campo;
    //     if (mb_strtoupper($campo, "UTF-8") == "TEORÍA") {
    //         $aperturaLabo = Apertura::where('apertura_periodo_id', $periodoId)
    //             ->where('apertura_asignatura_id', $asignaturaId)
    //             ->where('apertura_paralelo', $paralelo)
    //             ->where('apertura_campo', 'Laboratorio')
    //             ->first();

    //         array_push($misAperturasId, $aperturaLabo->apertura_id);
    //     }
    //     array_push($misAperturasId, $aperturaId);

    //     if ($docencia) {
    //         $asignaturasEstudiante = DB::table('estudiantes')
    //             ->select(
    //                 'semestre_numerico', 
    //                 'asignatura_sigla', 
    //                 'asignatura_nombre', 
    //                 'apertura_id', 
    //                 'apertura_paralelo', 
    //                 'apertura_campo', 
    //                 'asignatura_teoria', 
    //                 'asignatura_laboratorio', 
    //                 'asignatura_id', 
    //                 'apertura_inscripcion', 
    //                 'docencia_id',
    //                 'docencia_ponderacion'
    //             )
    //             ->distinct()
    //             ->join('inscripciones', 'inscripcion_estudiante_id', '=', 'estudiante_id')
    //             ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
    //             ->join('docencias', 'apertura_id', '=', 'docencia_apertura_id')
    //             ->join('docentes', 'docencia_docente_id', '=', 'docente_id')
    //             ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
    //             ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
    //             ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
    //             ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
    //             ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
    //             ->whereIn('apertura_id', $misAperturasId)
    //             ->where('asignatura_id', $asignaturaId)
    //             ->where('periodo_id', $periodoId)
    //             ->where('estudiante_persona_id', $personaId)
    //             ->orderBy('semestre_numerico')
    //             ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
    //             ->orderBy('asignatura_sigla')
    //             ->orderBy('apertura_campo', 'desc')
    //             ->get();

    //         $asignaturasEstudiante->transform(function ($ponderacion) {
    //             $ponderacion->docencia_ponderacion = json_decode($ponderacion->docencia_ponderacion, true);
    //             return $ponderacion;
    //         });
    //     } else{
    //         $asignaturasEstudiante = DB::table('estudiantes')
    //             ->select(
    //                 'semestre_numerico', 
    //                 'asignatura_sigla', 
    //                 'asignatura_nombre', 
    //                 'apertura_id', 
    //                 'apertura_paralelo', 
    //                 'apertura_campo', 
    //                 'asignatura_teoria', 
    //                 'asignatura_laboratorio', 
    //                 'asignatura_id', 
    //                 'apertura_inscripcion', 
    //                 'auxiliatura_id',
    //                 'auxiliatura_ponderacion'
    //             )
    //             ->distinct()
    //             ->join('inscripciones', 'inscripcion_estudiante_id', '=', 'estudiante_id')
    //             ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
    //             ->join('auxiliaturas', 'apertura_id', '=', 'auxiliatura_apertura_id')
    //             ->join('auxiliares', 'auxiliatura_auxiliar_id', '=', 'auxiliar_id')
    //             ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
    //             ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
    //             ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
    //             ->join('pensum', 'asignatura_id', '=', 'pensum_asignatura_id')
    //             ->join('semestres', 'pensum_semestre_id', '=', 'semestre_id')
    //             ->whereIn('apertura_id', $misAperturasId)
    //             ->where('asignatura_id', $asignaturaId)
    //             ->where('periodo_id', $periodoId)
    //             ->where('estudiante_persona_id', $personaId)
    //             ->orderBy('semestre_numerico')
    //             ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(asignatura_sigla, " ", -1) AS UNSIGNED)'))
    //             ->orderBy('asignatura_sigla')
    //             ->orderBy('apertura_campo', 'desc')
    //             ->get();

    //         $asignaturasEstudiante->transform(function ($ponderacion) {
    //             $ponderacion->auxiliatura_ponderacion = json_decode($ponderacion->auxiliatura_ponderacion, true);
    //             return $ponderacion;
    //         });
    //     }
            
    //     return $asignaturasEstudiante;
    // }
    public function actualizarPonderacionDocenciaApertura($request)
    {
        $docenciaId = $request->input('id');
        $tipo = $request->input('tipo');
        $ponderacionPrincipal = $request->input('ponderacion_principal');
        $ponderacionSecundaria = $request->input('ponderacion_secundaria');

        DB::beginTransaction();
        try {
            $docencia = Docencia::where('docencia_id', $docenciaId)->first();
            $ponderaciones = $docencia->docencia_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            
            $ponderaciones["ponderacionPrincipal"] = floatval($ponderacionPrincipal);
            $ponderaciones['ponderacionSecundaria'] = floatval($ponderacionSecundaria);
            
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'docencia_ponderacion' => $ponderaciones
            ];
            Docencia::where('docencia_id', $docenciaId)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }

    }
    public function actualizarPonderacionAuxiliaturaApertura($request)
    {
        $auxiliaturaId = $request->input('id');
        $tipo = $request->input('tipo');
        $ponderacionPrincipal = $request->input('ponderacion_principal');
        $ponderacionSecundaria = $request->input('ponderacion_secundaria');

        DB::beginTransaction();
        try {
            $auxiliatura = Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->first();
            $ponderaciones = $auxiliatura->auxiliatura_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            
            $ponderaciones["ponderacionPrincipal"] = floatval($ponderacionPrincipal);
            $ponderaciones['ponderacionSecundaria'] = floatval($ponderacionSecundaria);
            
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'auxiliatura_ponderacion' => $ponderaciones
            ];
            Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }

    }
    public function crearPonderacionDocencia($request)
    {
        $docenciaId = $request->input('id');
        $tipo = $request->input('tipo') == 'Actividades' ? 'Secundaria':'Principal';
        $ponderacion = $request->input('ponderacion');

        DB::beginTransaction();
        try {
            $docencia = Docencia::where('docencia_id', $docenciaId)->first();

            $ponderaciones = $docencia->docencia_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            $indice = (count($ponderaciones["ponderaciones".$tipo])+1);
            $ponderaciones["ponderaciones".$tipo][$indice] = floatval($ponderacion);
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'docencia_ponderacion' => $ponderaciones
            ];
            Docencia::where('docencia_id', $docenciaId)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }

    }
    public function crearPonderacionAuxiliatura($request)
    {
        $auxiliaturaId = $request->input('id');
        $tipo = $request->input('tipo') == 'Actividades' ? 'Secundaria':'Principal';
        $ponderacion = $request->input('ponderacion');

        DB::beginTransaction();
        try {
            $docencia = Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->first();

            $ponderaciones = $docencia->auxiliatura_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            $indice = (count($ponderaciones["ponderaciones".$tipo])+1);
            $ponderaciones["ponderaciones".$tipo][$indice] = floatval($ponderacion);
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'auxiliatura_ponderacion' => $ponderaciones
            ];
            Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }

    }
    public function actualizarPonderacionDocencia($request)
    {
        $docenciaId = $request->input('id');
        $tipo = $request->input('tipo') == 'Actividades' ? 'Secundaria':'Principal';
        $_ponderaciones = $request->input('ponderaciones');

        DB::beginTransaction();
        try {
            $docencia = Docencia::where('docencia_id', $docenciaId)->first();
            $ponderaciones = $docencia->docencia_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            
            foreach ($_ponderaciones as $i => $ponderacion) {
                $indice = ($i+1);
                $ponderaciones["ponderaciones".$tipo][$indice] = floatval($ponderacion);
            }
            
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'docencia_ponderacion' => $ponderaciones
            ];
            Docencia::where('docencia_id', $docenciaId)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function actualizarPonderacionAuxiliatura($request)
    {
        $auxiliaturaId = $request->input('id');
        $tipo = $request->input('tipo') == 'Actividades' ? 'Secundaria':'Principal';
        $_ponderaciones = $request->input('ponderaciones');

        DB::beginTransaction();
        try {
            $auxiliatura = Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->first();
            $ponderaciones = $auxiliatura->auxiliatura_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            
            foreach ($_ponderaciones as $i => $ponderacion) {
                $indice = ($i+1);
                $ponderaciones["ponderaciones".$tipo][$indice] = floatval($ponderacion);
            }
            
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'auxiliatura_ponderacion' => $ponderaciones
            ];
            Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function eliminarPonderacionDocencia($request)
    {
        $docenciaId = $request->input('id');
        $tipo = $request->input('tipo') == 'Actividades' ? 'Secundaria':'Principal';
        $indice = $request->input('indice');
        
        DB::beginTransaction();
        try {
            $docencia = Docencia::where('docencia_id', $docenciaId)->first();
            $aperturaId = $docencia->docencia_apertura_id;
            $ponderaciones = $docencia->docencia_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            unset($ponderaciones["ponderaciones".$tipo][$indice]);
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'docencia_ponderacion' => $ponderaciones
            ];
            Docencia::where('docencia_id', $docenciaId)->update($datos);
            
            $inscritos = Inscripcion::where('inscripcion_apertura_id', $aperturaId)->get();
            foreach ($inscritos as $key => $inscrito) {
                $notas = $inscrito->inscripcion_nota_docencia;
                $notas = json_decode($notas, true);
                unset($notas["nota".$tipo][$indice-1]);
                $notas = json_encode($notas);
                
                $datos = [
                    'inscripcion_nota_docencia' => $notas
                ];
                Inscripcion::where('inscripcion_id', $inscrito->inscripcion_id)->update($datos);
            }

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }

    }
    public function eliminarPonderacionAuxiliatura($request)
    {
        $auxiliaturaId = $request->input('id');
        $tipo = $request->input('tipo') == 'Actividades' ? 'Secundaria':'Principal';
        $indice = $request->input('indice');
        
        DB::beginTransaction();
        try {
            $auxiliatura = Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->first();
            $aperturaId = $auxiliatura->auxiliatura_apertura_id;
            $ponderaciones = $auxiliatura->auxiliatura_ponderacion;
            $ponderaciones = json_decode($ponderaciones, true);
            unset($ponderaciones["ponderaciones".$tipo][$indice]);
            $ponderaciones = json_encode($ponderaciones);

            $datos = [
                'auxiliatura_ponderacion' => $ponderaciones
            ];
            Auxiliatura::where('auxiliatura_id', $auxiliaturaId)->update($datos);
            
            $inscritos = Inscripcion::where('inscripcion_apertura_id', $aperturaId)->get();
            foreach ($inscritos as $key => $inscrito) {
                $notas = $inscrito->inscripcion_nota_auxiliatura;
                $notas = json_decode($notas, true);
                unset($notas["nota".$tipo][$indice-1]);
                $notas = json_encode($notas);
                
                $datos = [
                    'inscripcion_nota_auxiliatura' => $notas
                ];
                Inscripcion::where('inscripcion_id', $inscrito->inscripcion_id)->update($datos);
            }

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }

    }
    public function eliminarAsignaturaInscrita($inscripcionId)
    {
        DB::beginTransaction();
        try {
            Inscripcion::where('inscripcion_id', $inscripcionId)->delete();

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    
    public function paralelosHabilitadosParaInscripcion($planEstudios, $periodo, $gestion)
    {
        $paralelosHabilitadosParaInscripcion = DB::table('aperturas')
        ->select('asignatura_sigla', 'apertura_paralelo', 'apertura_campo', 'asignatura_id', 'apertura_id')
        ->distinct()
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        ->where('plan_estudio_nombre', $planEstudios)
        ->where('periodo_nombre', $periodo)
        ->where('periodo_gestion', $gestion)
        ->whereIn('apertura_inscripcion', [0, 1])
        ->where('apertura_estado', 1)
        ->orderBy('apertura_paralelo')
        ->get();
        return $paralelosHabilitadosParaInscripcion;
    }
    public function periodo($periodoId)
    {
        $periodo = DB::table('periodos')->where('periodo_id', $periodoId)->first();
        return $periodo;
    }
    public function periodoPorInscripcionId($inscripcionId)
    {
        $periodo = Inscripcion::select('periodo_id', 'periodo_nombre', 'periodo_gestion')
                ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
                ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
                ->where('inscripcion_id', $inscripcionId)
                ->first();

        return $periodo;
    }
    public function asignaturaPorInscripcionId($inscripcionId)
    {
        $asignatura = Inscripcion::select('apertura_campo', 'asignatura_id', 'asignatura_sigla')
            ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
            ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
            ->where('inscripcion_id', $inscripcionId)
            ->first();

        return $asignatura;
    }
    public function asignaturaPorAperturaId($id)
    {
        $asignatura = Asignatura::join('aperturas', 'asignatura_id', '=', 'apertura_asignatura_id')
            ->where('apertura_id', $id)
            ->first();

        return $asignatura;
    }
    public function estudianteIdPorPersonaId($personaId)
    {
        $estudianteId = DB::table('estudiantes')
        ->where('estudiante_persona_id', $personaId)
        ->value('estudiante_id');
        return $estudianteId;
    }
    public function registrarInscripciones($estudianteId, $aperturaId)
    {
        $apertura = DB::table('aperturas')
        ->select('apertura_periodo_id', 'apertura_asignatura_id', 'apertura_paralelo', 'asignatura_laboratorio')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->where('apertura_id', $aperturaId)
        ->get();
        
        DB::beginTransaction();
        try {
            $aperturaIdLaboratorio = DB::table('aperturas')
            ->where('apertura_periodo_id', $apertura[0]->apertura_periodo_id)
            ->where('apertura_asignatura_id', $apertura[0]->apertura_asignatura_id)
            ->where('apertura_paralelo', $apertura[0]->apertura_paralelo)
            ->where('apertura_campo', 'Laboratorio')
            ->whereNull('apertura_inscripcion')
            ->value('apertura_id');
            
            if (!empty($aperturaIdLaboratorio)) {
                $laboratorio = ['inscripcion_estudiante_id' => $estudianteId, 'inscripcion_apertura_id' => $aperturaIdLaboratorio,'inscripcion_fecha' => date('Y-m-d H:i:s'), 'inscripcion_estado' => 1];
                DB::table('inscripciones')->insert($laboratorio);
            }

            $teoria = ['inscripcion_estudiante_id' => $estudianteId, 'inscripcion_apertura_id' => $aperturaId,'inscripcion_fecha' => date('Y-m-d H:i:s'), 'inscripcion_estado' => 1];
            DB::table('inscripciones')->insert($teoria);
            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function ultimoPeriodoAuxiliarPorPersonaId($personaId)
    {
        $periodo = DB::table('estudiantes')
            ->select('periodo_id', 'periodo_gestion', 'periodo_nombre')
            ->join('auxiliares', 'estudiante_id', '=', 'auxiliar_estudiante_id')
            ->join('auxiliaturas', 'auxiliar_id', '=', 'auxiliatura_auxiliar_id')
            ->join('aperturas', 'auxiliatura_apertura_id', '=', 'apertura_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->where('estudiante_persona_id', $personaId)
            ->orderBy('periodo_id', 'desc')
            ->first();

        return $periodo;
    }
    public function ultimoPeriodoDocentePorPersonaId($personaId)
    {
        $periodo = DB::table('docentes')
            ->select('periodo_id', 'periodo_gestion', 'periodo_nombre')
            ->join('docencias', 'docente_id', '=', 'docencia_docente_id')
            ->join('aperturas', 'docencia_apertura_id', '=', 'apertura_id')
            ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
            ->where('docente_persona_id', $personaId)
            ->orderBy('periodo_id', 'desc')
            ->first();

        return $periodo;
    }
    public function estudiantesInscritosMateria($aperturaId)
    {
        $inscritos = Persona::select(
                'personas.*', 'asignaturas.*', 'correo_direccion', 'celular_numero','estudiante_id', 
                'inscripcion_id', 'apertura_id', 'inscripcion_nota_docencia', 'inscripcion_nota_auxiliatura'
            )
            ->join('estudiantes', 'persona_id', '=', 'estudiante_persona_id')
            ->join('inscripciones', 'estudiante_id', '=', 'inscripcion_estudiante_id')
            ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
            ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('celulares', 'persona_id', '=', 'celular_persona_id')
            ->join('correos', 'persona_id', '=', 'correo_persona_id')
            ->where('inscripcion_estado', 1)
            ->where('apertura_id', $aperturaId)
            ->get();
        $inscritos->transform(function ($nota) {
            $nota->inscripcion_nota_docencia = json_decode($nota->inscripcion_nota_docencia, true);
            return $nota;
        });
        $inscritos->transform(function ($nota) {
            $nota->inscripcion_nota_auxiliatura = json_decode($nota->inscripcion_nota_auxiliatura, true);
            return $nota;
        });
        
        return $inscritos;
    }
    public function estudianteInscritoMateria($personaId, $aperturaId)
    {
        $inscrito = Persona::select(
                'personas.*', 'asignaturas.*', 'correo_direccion', 'celular_numero', 'estudiante_id', 'estudiante_ru', 
                'inscripcion_id', 'apertura_id', 'inscripcion_nota_docencia', 'inscripcion_nota_auxiliatura'
            )
            ->join('estudiantes', 'persona_id', '=', 'estudiante_persona_id')
            ->join('inscripciones', 'estudiante_id', '=', 'inscripcion_estudiante_id')
            ->join('aperturas', 'inscripcion_apertura_id', '=', 'apertura_id')
            ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
            ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
            ->join('celulares', 'persona_id', '=', 'celular_persona_id')
            ->join('correos', 'persona_id', '=', 'correo_persona_id')
            ->where('inscripcion_estado', 1)
            ->where('apertura_id', $aperturaId)
            ->where('estudiante_persona_id', $personaId)
            ->first();

        if ($inscrito) {
            $inscrito->inscripcion_nota_docencia = json_decode($inscrito->inscripcion_nota_docencia, true);
            $inscrito->inscripcion_nota_auxiliatura = json_decode($inscrito->inscripcion_nota_auxiliatura, true);
        }

        return $inscrito;
    }
    public function aperturaLaboratorioPorAperturaId($aperturaId)
    {
        $apertura = Apertura::where('apertura_id', $aperturaId)->first();
        $periodoId = $apertura->apertura_periodo_id;
        $asignaturaId = $apertura->apertura_asignatura_id;
        $paralelo = $apertura->apertura_paralelo;
        $aperturaIdLaboratorio = Apertura::where('apertura_asignatura_id', $asignaturaId)
            ->where('apertura_periodo_id', $periodoId)
            ->where('apertura_paralelo', $paralelo)
            ->where('apertura_campo', 'Laboratorio')
            ->value('apertura_id');

        return $aperturaIdLaboratorio;
    }
}
