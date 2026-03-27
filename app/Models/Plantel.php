<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Plantel extends Model
{
    private $rolAdministrativo = "ADMINISTRATIVO";
    private $rolDocente = "DOCENTE";
    private $rolAuxiliar = "AUXILIAR";
    private $rolEstudiante = "ESTUDIANTE";
    private $rolAdministrador = "ADMINISTRADOR";

    public function administrativos($estado = null)
    {
        $administrativos = DB::table('administrativos')->join('personas', 'administrativo_persona_id', '=', 'persona_id')
            ->join('cargos', 'administrativo_cargo_id', '=', 'cargo_id')
            ->where('administrativo_estado', 'like', '%'.$estado.'%')
            ->get();
        return $administrativos;
    }
    public function administrativoPorCi($ci, $estado = null)
    {
        $administrativoPorCi = DB::table('administrativos')->join('personas', 'administrativo_persona_id', '=', 'persona_id')
        ->join('cargos', 'administrativo_cargo_id', '=', 'cargo_id')
        ->where('persona_ci', $ci)
        ->where('administrativo_estado', 'like', '%'.$estado.'%')
        ->first();
        return $administrativoPorCi;
    }
    public function administrativosPorCi($ci, $estado = null)
    {
        $administrativosPorCi = DB::table('administrativos')->join('personas', 'administrativo_persona_id', '=', 'persona_id')
        ->join('cargos', 'administrativo_cargo_id', '=', 'cargo_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->where('administrativo_estado', 'like', '%'.$estado.'%')
        ->get();
        return $administrativosPorCi;
    }
    public function administrativosPorGestion($gestion, $estado = null)
    {
        $administrativosPorGestion = DB::table('administrativos')->join('personas', 'administrativo_persona_id', '=', 'persona_id')
            ->join('cargos', 'administrativo_cargo_id', '=', 'cargo_id')
            ->where('administrativo_estado', 'like', '%'.$estado.'%')
            ->get();
        return $administrativosPorGestion;
    }
    public function informacionPersonalAdministrativosPorCi($ci)
    {
        $informacionPersonalAdministrativosPorCi  = DB::table('administrativos')->select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci',
        'celular_pais_id', 'celular_numero', 'correo_direccion', 'domicilio_direccion', 'cargo_id', 'cargo_nombre', 'administrativo_estado', 'administrativo_id')
        ->join('cargos', 'administrativo_cargo_id', '=', 'cargo_id')
        ->join('personas', 'administrativo_persona_id', '=', 'persona_id')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->join('domicilios', 'correo_persona_id', '=', 'domicilio_persona_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->get();
        
        return $informacionPersonalAdministrativosPorCi;
    }
    public function actualizarInformacionPersonalAdministrativo($request)
    {
        $id = $request->input('id');
        $ci = $request->input('ci');
        $primerApellido = mb_strtoupper($request->input('primer_apellido'), "UTF-8");
        $segundoApellido = mb_strtoupper($request->input('segundo_apellido'), "UTF-8");
        $nombres = mb_strtoupper($request->input('nombres'), "UTF-8");
        $celular = $request->input('celular');
        $correo = $request->input('correo');
        $cargoId = $request->input('cargo_id');
        
        DB::beginTransaction();
        try {
            $personaId = Administrativo::where('administrativo_id', $id)->value('administrativo_persona_id');
            $datos = [
                'persona_primer_apellido' => $primerApellido,
                'persona_segundo_apellido' => $segundoApellido,
                'persona_nombres' => $nombres,
                'persona_ci' => $ci,
            ];
            Persona::where('persona_id', $personaId)->update($datos);

            $datos = [
                'celular_numero' => $celular
            ];
            Celular::where('celular_persona_id', $personaId)->update($datos);
            
            $datos = [
                'correo_direccion' => $correo
            ];
            Correo::where('correo_persona_id', $personaId)->update($datos);

            $datos = [
                'administrativo_cargo_id' => $cargoId
            ];
            Administrativo::where('administrativo_id', $id)->update($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function agregarAdministrativoPorCi($ci, $cargoId)
    {
        DB::beginTransaction();
        try {
            $personaId = Persona::where('persona_ci', $ci)->value('persona_id');

            $datos = [
                'administrativo_persona_id' => $personaId,
                'administrativo_cargo_id' => $cargoId,
                'administrativo_estado' => 1
            ];
            Administrativo::create($datos);

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolAdministrativo)->value('rol_id');
            $datos = [
                'acceso_usuario_id' => $usuarioId,
                'acceso_rol_id' => $rolId,
                'acceso_nivel' => 1,
            ];
            DB::table('accesos')->insert($datos);
            
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function eliminarAdministrativo($id)
    {
        DB::beginTransaction();
        try {
            // agregar una condición para verificar si el personal no tiene datos enlazados a otras tablas
            $personaId = Administrativo::where('administrativo_id', $id)->value('administrativo_persona_id');
            
            Administrativo::where('administrativo_id', $id)->delete();

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolAdministrativo)->value('rol_id');
            DB::table('accesos')->where('acceso_usuario_id', $usuarioId)->where('acceso_rol_id', $rolId)->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function inhabilitarAdministrativo($id)
    {
        try {
            DB::table('administrativos')->where('administrativo_id', $id)
            ->update(['administrativo_estado'=> 0]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function habilitarAdministrativo($id)
    {
        try {
            DB::table('administrativos')->where('administrativo_id', $id)
            ->update(['administrativo_estado'=> 1]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function auxiliares($estado = null)
    {
        $auxiliares = DB::table('auxiliares')->join('estudiantes', 'auxiliar_estudiante_id', '=', 'estudiante_id')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->where('auxiliar_estado', 'like', '%'.$estado.'%')
        ->orderBy('persona_nombres')
        ->orderBy('persona_primer_apellido')
        ->orderBy('persona_segundo_apellido')
        ->get();
        return $auxiliares;
    }
    public function auxiliarPorCi($ci, $estado = null)
    {
        $auxiliarPorCi = DB::table('auxiliares')->join('estudiantes', 'auxiliar_estudiante_id', '=', 'estudiante_id')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->where('persona_ci', $ci)
        ->where('auxiliar_estado', 'like', '%'.$estado.'%')
        ->first();
        return $auxiliarPorCi;
    }
    public function auxiliaresPorCi($ci, $estado = null)
    {
        $auxiliaresPorCi = DB::table('auxiliares')->join('estudiantes', 'auxiliar_estudiante_id', '=', 'estudiante_id')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->where('auxiliar_estado', 'like', '%'.$estado.'%')
        ->get();
        return $auxiliaresPorCi;
    }
    public function auxiliaresPorGestion($gestion, $estado = null)
    {
        $auxiliaresPorGestion = DB::table('auxiliares')->select('persona_id', 'persona_nombres', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_ci', 'estudiante_ru', 'periodo_gestion')
        ->distinct()
        ->join('estudiantes', 'auxiliar_estudiante_id', '=', 'estudiante_id')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->join('auxiliaturas', 'auxiliar_id', '=', 'auxiliatura_auxiliar_id')
        ->join('aperturas', 'auxiliatura_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->where('periodo_gestion', $gestion)
        ->where('auxiliar_estado', 'like', '%'.$estado.'%')
        ->get();
        return $auxiliaresPorGestion;
    }
    public function auxiliarPorPersonaId($personaId, $estado = null)
    {
        $auxiliar = DB::table('auxiliares')
        ->join('estudiantes', 'auxiliar_estudiante_id', '=', 'auxiliar_id')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->where('estudiante_persona_id', $personaId)
        ->where('auxiliar_estado', 'like', '%'.$estado.'%')
        ->first();
        return $auxiliar;
    }
    public function informacionPersonalAuxiliaresPorCi($ci)
    {
        $informacionPersonalAuxiliaresPorCi  = DB::table('auxiliares')->select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci',
        'celular_pais_id', 'celular_numero', 'correo_direccion', 'domicilio_direccion', 'estudiante_id', 'estudiante_ru', 'auxiliar_id', 'auxiliar_estado')
        ->join('estudiantes', 'auxiliar_estudiante_id', '=', 'estudiante_id')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->join('domicilios', 'correo_persona_id', '=', 'domicilio_persona_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->get();
        
        return $informacionPersonalAuxiliaresPorCi;
    }
    public function actualizarInformacionPersonalAuxiliar($request)
    {
        $id = $request->input('id');
        $ci = $request->input('ci');
        $ru = $request->input('ru');
        $primerApellido = mb_strtoupper($request->input('primer_apellido'), "UTF-8");
        $segundoApellido = mb_strtoupper($request->input('segundo_apellido'), "UTF-8");
        $nombres = mb_strtoupper($request->input('nombres'), "UTF-8");
        $celular = $request->input('celular');
        $correo = $request->input('correo');
        
        DB::beginTransaction();
        try {
            $personaId = Auxiliar::join('estudiantes', 'auxiliar_estudiante_id', '=', 'estudiante_id')
                ->where('auxiliar_id', $id)->value('estudiante_persona_id');
            $datos = [
                'persona_primer_apellido' => $primerApellido,
                'persona_segundo_apellido' => $segundoApellido,
                'persona_nombres' => $nombres,
                'persona_ci' => $ci,
            ];
            Persona::where('persona_id', $personaId)->update($datos);
            
            $datos = [
                'celular_numero' => $celular
            ];
            Celular::where('celular_persona_id', $personaId)->update($datos);
            
            $datos = [
                'correo_direccion' => $correo
            ];
            Correo::where('correo_persona_id', $personaId)->update($datos);

            $datos = [
                'estudiante_ru' => $ru
            ];
            Estudiante::where('estudiante_persona_id', $personaId)->update($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function agregarAuxiliarPorRu($ru)
    {
        DB::beginTransaction();
        try {
            $estudianteId = Estudiante::where('estudiante_ru', $ru)->value('estudiante_id');
            $personaId = Estudiante::where('estudiante_id', $estudianteId)->value('estudiante_persona_id');

            $datos = [
                'auxiliar_estudiante_id' => $estudianteId,
                'auxiliar_estado' => 1
            ];
            Auxiliar::create($datos);

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolAuxiliar)->value('rol_id');
            $datos = [
                'acceso_usuario_id' => $usuarioId,
                'acceso_rol_id' => $rolId,
                'acceso_nivel' => 1,
            ];
            DB::table('accesos')->insert($datos);
            
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function eliminarAuxiliar($id)
    {
        DB::beginTransaction();
        try {
            // agregar una condición para verificar si el personal no tiene datos enlazados a otras tablas
            $estudianteId = Auxiliar::where('auxiliar_id', $id)->value('auxiliar_estudiante_id');
            $personaId = Estudiante::where('estudiante_id', $estudianteId)->value('estudiante_persona_id');
            
            Auxiliar::where('auxiliar_id', $id)->delete();

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolAuxiliar)->value('rol_id');
            DB::table('accesos')->where('acceso_usuario_id', $usuarioId)->where('acceso_rol_id', $rolId)->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function inhabilitarAuxiliar($id)
    {
        try {
            DB::table('auxiliares')->where('auxiliar_id', $id)
            ->update(['auxiliar_estado'=> 0]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function habilitarAuxiliar($id)
    {
        try {
            DB::table('auxiliares')->where('auxiliar_id', $id)
            ->update(['auxiliar_estado'=> 1]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function categorias()
    {
        $categorias = DB::table('categorias')->get();
        return $categorias;
    }
    public function cargos()
    {
        $cargos = DB::table('cargos')->get();
        return $cargos;
    }
    public function docentes($estado = null)
    {
        $docentes = DB::table('docentes')->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->join('categorias', 'docente_categoria_id', '=', 'categoria_id')
        ->where('docente_estado', 'like', '%'.$estado.'%')
        ->orderBy('persona_nombres')
        ->orderBy('persona_primer_apellido')
        ->orderBy('persona_segundo_apellido')
        ->get();
        return $docentes;
    }
    public function docentePorCi($ci, $estado = null)
    {
        $docentePorCi = DB::table('docentes')->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->join('categorias', 'docente_categoria_id', '=', 'categoria_id')
        ->where('persona_ci', $ci)
        ->where('docente_estado', 'like', '%'.$estado.'%')
        ->first();
        return $docentePorCi;
    }
    public function docentesPorCi($ci, $estado = null)
    {
        $docentesPorCi = DB::table('docentes')->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->join('categorias', 'docente_categoria_id', '=', 'categoria_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->where('docente_estado', 'like', '%'.$estado.'%')
        ->get();
        return $docentesPorCi;
    }
    public function docentePorPersonaId($personaId, $estado = null)
    {
        $docentePorCi = DB::table('docentes')->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->join('categorias', 'docente_categoria_id', '=', 'categoria_id')
        ->where('docente_persona_id', $personaId)
        ->where('docente_estado', 'like', '%'.$estado.'%')
        ->first();
        return $docentePorCi;
    }
    public function docentesPorGestion($gestion, $estado = null)
    {
        $docentesPorGestion = DB::table('docentes')->select('persona_id', 'persona_nombres', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_ci', 'categoria_nombre', 'periodo_gestion')
        ->distinct()
        ->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->join('categorias', 'docente_categoria_id', '=', 'categoria_id')
        ->join('docencias', 'docente_id', '=', 'docencia_docente_id')
        ->join('aperturas', 'docencia_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->where('periodo_gestion', $gestion)
        ->where('docente_estado', 'like', '%'.$estado.'%')
        ->get();
        return $docentesPorGestion;
    }
    public function informacionPersonalDocentesPorCi($ci)
    {
        $informacionPersonalDocentesPorCi  = DB::table('docentes')->select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci',
        'celular_pais_id', 'celular_numero', 'correo_direccion', 'domicilio_direccion', 'categoria_id', 'categoria_nombre', 'docente_id', 'docente_grado', 'docente_estado')
        ->join('categorias', 'docente_categoria_id', '=', 'categoria_id')
        ->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->join('domicilios', 'correo_persona_id', '=', 'domicilio_persona_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->get();
        
        return $informacionPersonalDocentesPorCi;
    }
    public function actualizarInformacionPersonalDocente($request)
    {
        $id = $request->input('id');
        $ci = $request->input('ci');
        $primerApellido = mb_strtoupper($request->input('primer_apellido'), "UTF-8");
        $segundoApellido = mb_strtoupper($request->input('segundo_apellido'), "UTF-8");
        $nombres = mb_strtoupper($request->input('nombres'), "UTF-8");
        $celular = $request->input('celular');
        $correo = $request->input('correo');
        $grado = $request->input('grado');
        $categoriaId = $request->input('categoria_id');
        
        DB::beginTransaction();
        try {
            $personaId = Docente::where('docente_id', $id)->value('docente_persona_id');
            $datos = [
                'persona_primer_apellido' => $primerApellido,
                'persona_segundo_apellido' => $segundoApellido,
                'persona_nombres' => $nombres,
                'persona_ci' => $ci,
            ];
            Persona::where('persona_id', $personaId)->update($datos);

            $datos = [
                'celular_numero' => $celular
            ];
            Celular::where('celular_persona_id', $personaId)->update($datos);
            
            $datos = [
                'correo_direccion' => $correo
            ];
            Correo::where('correo_persona_id', $personaId)->update($datos);

            $datos = [
                'docente_categoria_id' => $categoriaId,
                'docente_grado' => $grado,
            ];
            Docente::where('docente_id', $id)->update($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function agregarDocentePorCi($ci, $categoriaId, $grado)
    {
        DB::beginTransaction();
        try {
            $personaId = Persona::where('persona_ci', $ci)->value('persona_id');

            $datos = [
                'docente_persona_id' => $personaId,
                'docente_categoria_id' => $categoriaId,
                'docente_grado' => $grado,
                'docente_estado' => 1
            ];
            Docente::create($datos);

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolDocente)->value('rol_id');
            $datos = [
                'acceso_usuario_id' => $usuarioId,
                'acceso_rol_id' => $rolId,
                'acceso_nivel' => 1,
            ];
            DB::table('accesos')->insert($datos);
            
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function eliminarDocente($id)
    {
        DB::beginTransaction();
        try {
            // agregar una condición para verificar si el personal no tiene datos enlazados a otras tablas
            $personaId = Docente::where('docente_id', $id)->value('docente_persona_id');
            
            Docente::where('docente_id', $id)->delete();

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolDocente)->value('rol_id');
            DB::table('accesos')->where('acceso_usuario_id', $usuarioId)->where('acceso_rol_id', $rolId)->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function inhabilitarDocente($id)
    {
        try {
            DB::table('docentes')->where('docente_id', $id)
            ->update(['docente_estado'=> 0]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function habilitarDocente($id)
    {
        try {
            DB::table('docentes')->where('docente_id', $id)
            ->update(['docente_estado'=> 1]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function estudiantePorCi($ci, $estado = null)
    {
        $estudiantePorCi = DB::table('estudiantes')->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->where('persona_ci', $ci)
        ->where('estudiante_estado', 'like', '%'.$estado.'%')
        ->first();
        return $estudiantePorCi;
    }
    public function estudianteIdPorPersonaId($personaId)
    {
        $estudianteIdPorPersonaId = DB::table('estudiantes')
        ->where('estudiante_persona_id', $personaId)
        ->value('estudiante_id');
        return $estudianteIdPorPersonaId;
    }
    public function estudiantePorPersonaId($personaId)
    {
        $estudiantePorPersonaId = DB::table('estudiantes')->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->where('estudiante_persona_id', $personaId)
        ->first();
        return $estudiantePorPersonaId;
    }
    public function informacionPersonalEstudiantesPorCi($ci)
    {
        $informacionPersonalEstudiantesPorCi  = DB::table('estudiantes')->select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci',
        'celular_pais_id', 'celular_numero', 'correo_direccion', 'domicilio_direccion', 'estudiante_id', 'estudiante_ru', 'estudiante_estado')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->join('domicilios', 'correo_persona_id', '=', 'domicilio_persona_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->get();
        
        return $informacionPersonalEstudiantesPorCi;
    }
    public function actualizarInformacionPersonalEstudiante($request)
    {
        $id = $request->input('id');
        $ci = $request->input('ci');
        $ru = $request->input('ru');
        $primerApellido = mb_strtoupper($request->input('primer_apellido'), "UTF-8");
        $segundoApellido = mb_strtoupper($request->input('segundo_apellido'), "UTF-8");
        $nombres = mb_strtoupper($request->input('nombres'), "UTF-8");
        $celular = $request->input('celular');
        $correo = $request->input('correo');
        
        DB::beginTransaction();
        try {
            $personaId = Estudiante::where('estudiante_id', $id)->value('estudiante_persona_id');
            $datos = [
                'persona_primer_apellido' => $primerApellido,
                'persona_segundo_apellido' => $segundoApellido,
                'persona_nombres' => $nombres,
                'persona_ci' => $ci,
            ];
            Persona::where('persona_id', $personaId)->update($datos);
            
            $datos = [
                'celular_numero' => $celular
            ];
            Celular::where('celular_persona_id', $personaId)->update($datos);
            
            $datos = [
                'correo_direccion' => $correo
            ];
            Correo::where('correo_persona_id', $personaId)->update($datos);

            $datos = [
                'estudiante_ru' => $ru
            ];
            Estudiante::where('estudiante_persona_id', $personaId)->update($datos);

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function agregarEstudiantePorCi($ci, $ru)
    {
        DB::beginTransaction();
        try {
            $personaId = Persona::where('persona_ci', $ci)->value('persona_id');

            $datos = [
                'estudiante_persona_id' => $personaId,
                'estudiante_ru' => $ru,
                'estudiante_estado' => 1
            ];
            Estudiante::create($datos);

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolEstudiante)->value('rol_id');
            $datos = [
                'acceso_usuario_id' => $usuarioId,
                'acceso_rol_id' => $rolId,
                'acceso_nivel' => 1,
            ];
            DB::table('accesos')->insert($datos);
            
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function eliminarEstudiante($id)
    {
        DB::beginTransaction();
        try {
            // agregar una condición para verificar si el personal no tiene datos enlazados a otras tablas
            $personaId = Estudiante::where('estudiante_id', $id)->value('estudiante_persona_id');
            
            Estudiante::where('estudiante_id', $id)->delete();

            $usuarioId = Usuario::where('usuario_persona_id', $personaId)->value('usuario_id');
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolEstudiante)->value('rol_id');
            DB::table('accesos')->where('acceso_usuario_id', $usuarioId)->where('acceso_rol_id', $rolId)->delete();
            $rolId = DB::table('roles')->where('rol_nombre', $this->rolAuxiliar)->value('rol_id');
            DB::table('accesos')->where('acceso_usuario_id', $usuarioId)->where('acceso_rol_id', $rolId)->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function inhabilitarEstudiante($id)
    {
        try {
            DB::table('estudiantes')->where('estudiante_id', $id)
            ->update(['estudiante_estado'=> 0]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function habilitarEstudiante($id)
    {
        try {
            DB::table('estudiantes')->where('estudiante_id', $id)
            ->update(['estudiante_estado'=> 1]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function asignaturasDocentePorCiGestion($ci, $gestion, $estado = null)
    {
        $asignaturasDocentePorCiGestion = DB::table('docentes')->select('asignatura_id', 'asignatura_sigla', 'asignatura_nombre', 'apertura_id', 'apertura_campo', 'apertura_paralelo')
        ->distinct()
        ->join('personas', 'docente_persona_id', '=', 'persona_id')
        ->join('docencias', 'docente_id', '=', 'docencia_docente_id')
        ->join('aperturas', 'docencia_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->where('persona_ci', $ci)
        ->where('periodo_gestion', $gestion)
        ->where('docente_estado', 'like', '%'.$estado.'%')
        ->orderBy('asignatura_sigla')
        ->get();
        return $asignaturasDocentePorCiGestion;
    }
    public function asignaturasAuxiliarPorCiGestion($ci, $gestion, $estado = null)
    {
        $asignaturasAuxiliarPorCiGestion = DB::table('auxiliares')->join('estudiantes', 'auxiliar_estudiante_id', '=', 'estudiante_id')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->join('auxiliaturas', 'auxiliar_id', '=', 'auxiliatura_auxiliar_id')
        ->join('aperturas', 'auxiliatura_apertura_id', '=', 'apertura_id')
        ->join('periodos', 'apertura_periodo_id', '=', 'periodo_id')
        ->join('asignaturas', 'apertura_asignatura_id', '=', 'asignatura_id')
        ->where('persona_ci', $ci)
        ->where('periodo_gestion', $gestion)
        ->where('auxiliar_estado', 'like', '%'.$estado.'%')
        ->get();
        return $asignaturasAuxiliarPorCiGestion;
    }
    public function verificarRu($ru)
    {
        $ru = DB::table('estudiantes')->where('estudiante_ru', $ru)->value('estudiante_ru');
        if (!empty($ru)) {
            return true;
        }
        else {
            return false;
        }
    }
    //UPDATE
    public function actualizarCargo($administrativoId, $cargo)
    {
        try {
            $cargo_id = DB::table('cargos')->where('cargo_nombre', $cargo)->value('cargo_id');
            DB::table('administrativos')->where('administrativo_id', $administrativoId)
            ->update(['administrativo_cargo_id'=> $cargo_id]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }     
    }
    public function actualizarCategoria($docenteId, $categoria)
    {
        try {
            $categoria_id = DB::table('categorias')->where('categoria_nombre', $categoria)->value('categoria_id');
            DB::table('docentes')->where('docente_id', $docenteId)
            ->update(['docente_categoria_id'=> $categoria_id]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }     
    }
    public function actualizarGrado($docenteId, $grado)
    {
        try {
            DB::table('docentes')->where('docente_id', $docenteId)
            ->update(['docente_grado'=> $grado]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }     
    }
    public function actualizarRu($estudianteId, $ru)
    {
        try {
            DB::table('estudiantes')->where('estudiante_id', $estudianteId)
            ->update(['estudiante_ru'=> $ru]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }     
    }

}
