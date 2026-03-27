<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Carrera extends Model
{
    private $rolAdministrativo = "ADMINISTRATIVO";
    private $rolDocente = "DOCENTE";
    private $rolAuxiliar = "AUXILIAR";
    private $rolEstudiante = "ESTUDIANTE";
    private $rolAdministrador = "ADMINISTRADOR";

    public function semestres()
    {
        $semestres = DB::table('semestres')->orderBy('semestre_numerico')->get();
        return $semestres;
    }
    public function aulas($estado = null)
    {
        $aulas = DB::table('aulas')
        ->where('aula_estado', 'like', '%'.$estado.'%')
        ->orderBy('aula_nombre')
        ->get();
        return $aulas;
    }
    public function menciones()
    {
        $menciones = DB::table('menciones')->orderBy('mencion_nombre')->get();
        return $menciones;
    }
    public function planesEstudios()
    {
        $planEstudios = DB::table('plan_estudios')->orderBy('plan_estudio_nombre')->get();
        return $planEstudios;
    }
    public function actualizarMencion($request)
    {
        $id = $request->input('id');
        $mencion = $request->input('mencion');

        DB::beginTransaction();
        try {
            $datos = [
                'mencion_nombre' => $mencion
            ];
            DB::table('menciones')->where('mencion_id', $id)->update($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function eliminarMencion($id)
    {
        DB::beginTransaction();
        try {
            DB::table('menciones')->where('mencion_id', $id)->delete();

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function crearMencion($request)
    {
        $mencion = $request->input('mencion');

        DB::beginTransaction();
        try {
            $datos = [
                'mencion_nombre' => $mencion
            ];
            DB::table('menciones')->insert($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function actualizarAula($request)
    {
        $id = $request->input('id');
        $aula = $request->input('aula');
        $capacidad = $request->input('capacidad');

        DB::beginTransaction();
        try {
            $datos = [
                'aula_nombre' => $aula,
                'aula_capacidad' => $capacidad,
            ];
            DB::table('aulas')->where('aula_id', $id)->update($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function eliminarAula($id)
    {
        DB::beginTransaction();
        try {
            DB::table('aulas')->where('aula_id', $id)->delete();

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function crearAula($request)
    {
        $aula = $request->input('aula');
        $capacidad = $request->input('capacidad');

        DB::beginTransaction();
        try {
            $datos = [
                'aula_nombre' => $aula,
                'aula_capacidad' => $capacidad,
            ];
            DB::table('aulas')->insert($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function actualizarPlanEstudio($request)
    {
        $id = $request->input('id');
        $planEstudio = $request->input('plan_estudio');

        DB::beginTransaction();
        try {
            $datos = [
                'plan_estudio_nombre' => $planEstudio,
            ];
            DB::table('plan_estudios')->where('plan_estudio_id', $id)->update($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function eliminarPlanEstudio($id)
    {
        DB::beginTransaction();
        try {
            DB::table('plan_estudios')->where('plan_estudio_id', $id)->delete();

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function crearPlanEstudio($request)
    {
        $planEstudio = $request->input('plan_estudio');

        DB::beginTransaction();
        try {
            $datos = [
                'plan_estudio_nombre' => $planEstudio
            ];
            DB::table('plan_estudios')->insert($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }

}
