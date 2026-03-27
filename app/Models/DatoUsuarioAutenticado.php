<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatoUsuarioAutenticado extends Model
{
    private $disk = "public";
    private $rolAdministrativo = "ADMINISTRATIVO";
    private $rolDocente = "DOCENTE";
    private $rolAuxiliar = "AUXILIAR";
    private $rolEstudiante = "ESTUDIANTE";
    private $rolAdministrador = "ADMINISTRADOR";

    public function informacionPersonalUsuariosPorCi($ci)
    {
        $informacionPersonalUsuariosPorCi  = DB::table('usuarios')->select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci',
        'celular_pais_id', 'celular_numero', 'correo_direccion', 'domicilio_direccion', 'usuario_id', 'usuario_usuario', 'usuario_estado')
        ->join('personas', 'usuario_persona_id', '=', 'persona_id')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->join('domicilios', 'correo_persona_id', '=', 'domicilio_persona_id')
        ->where('persona_ci', 'like', '%'.$ci.'%')
        ->get();
        
        return $informacionPersonalUsuariosPorCi;
    }
    public function actualizarInformacionPersonalUsuario($request)
    {
        $id = $request->input('id');
        $ci = $request->input('ci');
        $primerApellido = mb_strtoupper($request->input('primer_apellido'), "UTF-8");
        $segundoApellido = mb_strtoupper($request->input('segundo_apellido'), "UTF-8");
        $nombres = mb_strtoupper($request->input('nombres'), "UTF-8");
        $celular = $request->input('celular');
        $correo = $request->input('correo');
        
        DB::beginTransaction();
        try {
            $personaId = Usuario::where('usuario_id', $id)->value('usuario_persona_id');
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

            DB::commit();
            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }
    public function eliminarUsuario($id)
    {
        DB::beginTransaction();
        try {
            $personaId = Usuario::where('usuario_id', $id)->value('usuario_persona_id');
            Persona::where('persona_id', $personaId)->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function reiniciarClave($id)
    {
        DB::beginTransaction();
        try {
            $ci = Usuario::join('personas', 'usuario_persona_id', '=', 'persona_id')->where('usuario_id', $id)->value('persona_ci');
            $datos = ['usuario_clave' => password_hash($ci, PASSWORD_BCRYPT)];
            Usuario::where('usuario_id', $id)->update($datos);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
    public function inhabilitarUsuario($id)
    {
        try {
            DB::table('usuarios')->where('usuario_id', $id)
            ->update(['usuario_estado'=> 0]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function habilitarUsuario($id)
    {
        try {
            DB::table('usuarios')->where('usuario_id', $id)
            ->update(['usuario_estado'=> 1]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function registrarIntentosFallidosUsuario($usuario)
    {
        $id = Usuario::where('usuario_usuario', $usuario)->value('usuario_id');
        $intentosFallidos = Usuario::where('usuario_usuario', $usuario)->value('usuario_intentos_fallidos');
        
        try {
            Usuario::where('usuario_id', $id)
            ->update(['usuario_intentos_fallidos'=> $intentosFallidos + 1]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function reiniciarIntentosFallidosUsuario($usuario)
    {
        $id = Usuario::where('usuario_usuario', $usuario)->value('usuario_id');
        
        try {
            Usuario::where('usuario_id', $id)
            ->update(['usuario_intentos_fallidos'=> 0]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function verificarUsuario($usuario)
    {
        $verificarUsuario = Usuario::where('usuario_usuario', $usuario)->value('usuario_id');
        if (!empty($verificarUsuario)) {
            return true;
        }
        else{
            return false;
        }
    }
    public function verificarIntentosFallidosUsuario($usuario)
    {
        $verificarIntentosFallidos = Usuario::where('usuario_usuario', $usuario)->value('usuario_intentos_fallidos');
        if ($verificarIntentosFallidos < 3) {
            return true;
        }
        else{
            return false;
        }
    }
    public function verificarClavePorUsuario($usuario, $clave)
    {
        $hashedPassword = Usuario::where('usuario_usuario', $usuario)->value('usuario_clave');
        if (Hash::check($clave, $hashedPassword)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function verificarEstadoPorUsuario($usuario)
    {
        $verificarEstadoPorUsuario = Usuario::where('usuario_usuario', $usuario)->value('usuario_estado');
        if ($verificarEstadoPorUsuario === 0) {
            return false;
        }
        else {
            return true;
        }
    }
    public function verificarCi($ci)
    {
        $ci = DB::table('personas')->where('persona_ci', $ci)->value('persona_ci');
        if (!empty($ci)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function verificarUsuarioCorreo($usuario, $correo)
    {
        $verificarUsuarioCorreo  = Usuario::
        join('personas', 'usuario_persona_id', '=', 'persona_id')
        ->join('correos', 'persona_id', '=', 'correo_persona_id')
        ->where('usuario_usuario', $usuario)
        ->where('correo_direccion', $correo)
        ->value('usuario_id');
        
        if (!empty($verificarUsuarioCorreo)) {
            return true;
        }
        else{
            return false;
        }
    }
    public function enviarCodigoPorUsuarioCorreo($usuario, $correo)
    {
        DB::beginTransaction();
        try {
            $usuarioId = Usuario::where('usuario_usuario', $usuario)->value('usuario_id');
            DB::table('codigos')->where('codigo_usuario_id', $usuarioId)->update(['codigo_estado' => 0]);
            $datos = ['codigo_usuario_id' => $usuarioId, 'codigo_fecha' => date('Y-m-d H:i:s'), 'codigo_estado' => 1];
            $codigo = DB::table('codigos')->insertGetId($datos);//Procesar envio de $codigo por correos a $correo
            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function verificarUltimoCodigoPorUsuarioCodigo($usuario, $codigo)
    {
        $ultimoCodigo = Usuario::where('usuario_usuario', $usuario)->value('usuario_id');
        $ultimoCodigo = Usuario::
            join('codigos', 'usuario_id', '=', 'codigo_usuario_id')
            ->where('usuario_usuario', $usuario)
            ->orderBy('codigo_fecha', 'desc')->take(1)->value('codigo_id');
        
        if ($codigo == $ultimoCodigo) {
            return true;
        }
        else{
            return false;
        }
    }
    public function verificarEstadoPorCodigo($codigo)
    {
        //$codeState = DB::table('codigos')->find($codigo)->codigo_estado;//error si codigo_estado es nulo
        $verificarEstadoPorCodigo = DB::table('codigos')->where('codigo_id', $codigo)->value('codigo_estado');//Revisar xq code 36a = 36
        
        if ($verificarEstadoPorCodigo == 1) {
            return true;
        }
        else{
            return false;
        }
    }
    public function actualizarClavePorUsuarioCodigo($usuario, $clave, $codigo)
    {
        DB::beginTransaction();
        try {
            Usuario::where('usuario_usuario', $usuario)->update(['usuario_clave'=> $clave]);
            DB::table('codigos')->where('codigo_id', $codigo)->update(['codigo_estado'=> 0]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function datosPersonaPorUsuarioId($usuarioId)
    {
        $datosPersonaPorUsuarioId = DB::table('personas')->select('persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci')
                    ->join('usuarios', 'persona_id', '=', 'usuario_persona_id')
                    ->where('usuario_id', $usuarioId)
                    ->first();
        return $datosPersonaPorUsuarioId;
    }
    public function personIdForCi($ci)
    {
        $personaId = DB::table('personas')->
                    where('persona_ci', $ci)
                    ->value('persona_id');
        return $personaId;
    }
    public function roles()
    {
        $roles = DB::table('roles')->orderByDesc('rol_id')->get();
        return $roles;
    }
    public function rolInicialUsuarioPorUsuarioId($usuarioId)
    {
        $rolInicialUsuarioPorUsuarioId = DB::table('roles')->select('rol_nombre', 'acceso_nivel')
                    ->join('accesos', 'rol_id', '=', 'acceso_rol_id')
                    ->where('acceso_usuario_id', $usuarioId)
                    ->orderByDesc('rol_nombre')
                    ->take(1)
                    ->first();
        return $rolInicialUsuarioPorUsuarioId;
    }
    public function rolesUsuarioPorUsarioId($usuarioId)
    {
        $rolesUsuarioPorUsarioId = DB::table('roles')->select('rol_nombre', 'acceso_nivel')
                    ->join('accesos', 'rol_id', '=', 'acceso_rol_id')
                    ->where('acceso_usuario_id', $usuarioId)
                    ->get();
        return $rolesUsuarioPorUsarioId;
    }
    public function rolPorUsuarioIdRol($usuarioId, $rol)
    {
        $rolPorUsuarioIdRol = DB::table('roles')->select('rol_nombre')
                    ->join('accesos', 'rol_id', '=', 'acceso_rol_id')
                    ->where('acceso_usuario_id', $usuarioId)
                    ->where('rol_nombre', $rol)
                    ->first();
        return $rolPorUsuarioIdRol;
    }
    // public function nombreFotoPerfilPorPersonaId($personaId)
    // {
    //     $nombreFotoPerfilPorPersonaId = DB::table('fotos')->select('foto_archivo')
    //                 ->join('personas', 'foto_persona_id', '=', 'persona_id')
    //                 ->where('persona_id', $personaId)
    //                 ->first();
    //     return $nombreFotoPerfilPorPersonaId;
    // }
    public function nombreFotoPerfilPorPersonaId($personaId)
    {
        return Foto::where('foto_persona_id', $personaId)->first();
    }
    public function informacionPersonalPorPersonaId($personaId)
    {
        $informacionPersonalPorPersonaId  = DB::table('personas')->
        select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci',
        'celular_pais_id', 'celular_numero', 'correo_direccion', 'domicilio_direccion')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->join('domicilios', 'correo_persona_id', '=', 'domicilio_persona_id')
        ->where('persona_id', $personaId)
        ->first();
        
        return $informacionPersonalPorPersonaId;
    }
    public function informacionPersonalPorCi($ci)
    {
        $informacionPersonalPorCi  = DB::table('personas')->
        select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci',
        'celular_pais_id', 'celular_numero', 'correo_direccion')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->where('persona_ci', $ci)
        ->first();
        
        return $informacionPersonalPorCi;
    }
    public function informacionPersonalPorRu($ru)
    {
        $informacionPersonalPorRu  = DB::table('estudiantes')->
        select('persona_id', 'persona_primer_apellido', 'persona_segundo_apellido', 'persona_nombres', 'persona_ci', 'estudiante_ru',
        'celular_pais_id', 'celular_numero', 'correo_direccion')
        ->join('personas', 'estudiante_persona_id', '=', 'persona_id')
        ->join('celulares', 'persona_id', '=', 'celular_persona_id')
        ->join('correos', 'celular_persona_id', '=', 'correo_persona_id')
        ->where('estudiante_ru', $ru)
        ->first();
        
        return $informacionPersonalPorRu;
    }
    public function actualizarNombreCompleto($personaId, $primer_apellido, $segundo_apellido, $nombres)
    {
        try {
            DB::table('personas')->where('persona_id', $personaId)
            ->update(['persona_primer_apellido'=> $primer_apellido, 'persona_segundo_apellido'=> $segundo_apellido, 'persona_nombres'=> $nombres]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }     
    }
    public function actualizarCi($personaId, $ci)
    {
        try {
            DB::table('personas')->where('persona_id', $personaId)
            ->update(['persona_ci'=> $ci]);
            return true;
        }
        catch (\Throwable $th) {
            return false;
        }     
    }
    public function verificarFotoPerfilPorPersonaId($personaId)
    {
        $foto = DB::table('fotos')->where('foto_persona_id', $personaId)->value('foto_id');
        if (!empty($foto)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function actualizarFotoPerfilPorPersonaId($personaId, $foto, $nombreFoto)
    {
        DB::beginTransaction();
        try {
            DB::table('fotos')->where('foto_persona_id', $personaId)->update(['foto_archivo'=> $nombreFoto]);
            $foto->storeAs('/fotos/usuarios/', $nombreFoto, $this->disk);
            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }     
    }
    public function subirFotoPerfilPorPersonaId($personaId, $foto, $nombreFoto)
    {
        DB::beginTransaction();
        try {
            $datos = ['foto_persona_id' => $personaId, 'foto_archivo' => $nombreFoto];
            Foto::create($datos);
            $foto->storeAs('/fotos/usuarios/', $nombreFoto, $this->disk);
            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }     
    }
    public function actualizarDomicilioPorPersonaId($personaId, $domicilio)
    {
        try {
            DB::table('domicilios')->where('domicilio_persona_id', $personaId)->update(['domicilio_direccion'=> $domicilio]);
            return true;
        } 
        catch (\Throwable $th) {
            return false;
        }
    }
    public function verificarCorreo($correo)
    {
        $correo = DB::table('correos')->where('correo_direccion', $correo)->value('correo_id');
        if (!empty($correo)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function actualizarCorreoPorPersonaId($personaId, $correo)
    {
        try {
            DB::table('correos')->where('correo_persona_id', $personaId)->update(['correo_direccion'=> $correo]);
            return true;
        } 
        catch (\Throwable $th) {
            return false;
        }
    }
    public function verificarCodigoPais($codigo)
    {
        $codigo = DB::table('celulares')->where('celular_pais_id', $codigo)->value('celular_id');
        if (!empty($codigo)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function verificarCelular($codigo, $celular)
    {
        $celular = DB::table('celulares')->where('celular_pais_id', $codigo)->where('celular_numero', $celular)->value('celular_id');
        if (!empty($celular)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function actualizarCelularPorPersonaId($personaId, $codigo, $celular)
    {
        try {
            DB::table('celulares')->where('celular_persona_id', $personaId)->update(['celular_pais_id'=> $codigo, 'celular_numero'=> $celular]);
            return true;
        } 
        catch (\Throwable $th) {
            return false;
        }
    }
    public function verificarClavePorUsuarioId($usuarioId, $clave_actual)
    {
        $hashedPassword = Usuario::find($usuarioId)->usuario_clave;
        if (Hash::check($clave_actual, $hashedPassword)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function actualizarClave($usuarioId, $clave)
    {
        try {
            Usuario::where('usuario_id', $usuarioId)->update(['usuario_clave'=> $clave, 'usuario_estado' => 1]);
            return true;
        } 
        catch (\Throwable $th) {
            return false; 
        }
    }
    public function crearUsuario($request)
    {
        $primerApellido = mb_strtoupper($request->input('primer_apellido'), "UTF-8");
        $segundoApellido = mb_strtoupper($request->input('segundo_apellido'), "UTF-8");
        $nombres = mb_strtoupper($request->input('nombres'), "UTF-8");
        $ci = $request->input('ci');
        $celular = $request->input('celular');
        $correo = $request->input('correo');
        $rolId = $request->input('rol_id');
        // Siempre hay un valor
        $categoriaId = $request->input('categoria_id') ?? null;
        $grado = $request->input('grado') ?? null;
        $cargoId = $request->input('cargo_id') ?? null;
        $ru = $request->input('ru') ?? null;
        $auxiliar = $request->input('auxiliar') ?? null;
        // Por defecto => Bolivia
        $paisId = $request->input('pais_id') ?? 591;

        $clave = password_hash($ci, PASSWORD_DEFAULT);

        DB::beginTransaction();
        try {
            //Personas
            $datos = [
                'persona_primer_apellido' => $primerApellido,
                'persona_segundo_apellido' => $segundoApellido,
                'persona_nombres' => $nombres,
                'persona_ci' => $ci
            ];
            $personaId = Persona::create($datos);
            $personaId = $personaId->persona_id;

            //Celular
            $datos = [
                'celular_persona_id' => $personaId,
                'celular_pais_id' => $paisId,
                'celular_numero' => $celular
            ];
            DB::table('celulares')->insert($datos);

            //Correo
            $datos = [
                'correo_persona_id' => $personaId,
                'correo_direccion' => $correo
            ];
            DB::table('correos')->insert($datos);

            //Domicilio
            $datos = [
                'domicilio_persona_id' => $personaId,
                'domicilio_direccion' => 'Zona/Calle/Número'
            ];
            DB::table('domicilios')->insert($datos);

            //Usuario
            $datos = [
                'usuario_persona_id' => $personaId,
                'usuario_usuario' => $ci,
                'usuario_clave' => $clave,
                'usuario_estado' => 1,
            ];
            $usuarioId = Usuario::create($datos);
            $usuarioId = $usuarioId->usuario_id;

            //Acceso
            $datos = [
                'acceso_usuario_id' => $usuarioId,
                'acceso_rol_id' => $rolId,
                'acceso_nivel' => 1
            ];
            DB::table('accesos')->insert($datos);

            switch ($rolId) {
                case 2:
                    # Administrativo
                    $datos = [
                        'administrativo_persona_id' => $personaId,
                        'administrativo_cargo_id' => $cargoId,
                        'administrativo_estado' => 1,
                    ];
                    DB::table('administrativos')->insert($datos);
                    break;
                case 3:
                    # Auxiliar
                    break;
                case 4:
                    # Docente
                    $datos = [
                        'docente_persona_id' => $personaId,
                        'docente_categoria_id' => $categoriaId,
                        'docente_grado' => $grado,
                        'docente_estado' => 1,
                    ];
                    DB::table('docentes')->insert($datos);
                    break;
                case 5:
                    # Estudiante
                    $datos = [
                        'estudiante_persona_id' => $personaId,
                        'estudiante_ru' => $ru,
                        'estudiante_estado' => 1,
                    ];
                    $estudianteId = DB::table('estudiantes')->insertGetId($datos);
                    if ($auxiliar == "SI") {
                        $datos = [
                            'auxiliar_estudiante_id' => $estudianteId,
                            'auxiliar_estado' => 1,
                        ];
                        DB::table('auxiliares')->insert($datos);

                        //Acceso
                        $rolId = DB::table('roles')->where('rol_nombre', $this->rolAuxiliar)->value('rol_id');
                        $datos = [
                            'acceso_usuario_id' => $usuarioId,
                            'acceso_rol_id' => $rolId,
                            'acceso_nivel' => 1
                        ];
                        DB::table('accesos')->insert($datos);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }

            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
    
    
}