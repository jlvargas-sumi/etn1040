<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Publicacion
{
    private $accion = 'Insertar';
    private $comunicado = 'Comunicado';
    private $convocatoria = 'Convocatoria';
    private $disk = "public";

    public function buscarPublicaciones($totalFilasPagina, $pagina = null, $seleccionarParametro = null, $valorParametro = null, $tipo = null, $estado = null)
    {
        switch ($seleccionarParametro) {
            case 'numero':
                $totalFilas = count($this->publicacionesPorNumero($valorParametro, $tipo, $estado));
                break;
            case 'descripcion':
                $totalFilas = count($this->publicacionesPorDescripcion($valorParametro, $tipo, $estado));
                break;
            case 'fecha':
                $totalFilas = count($this->publicacionesPorFecha($valorParametro, $tipo, $estado));
                break;
            default:
                $totalFilas = count($this->publicaciones($tipo, $estado));
                break;
        }

        if (($totalFilas % $totalFilasPagina) == 0) {
            $totalPaginas = $totalFilas / $totalFilasPagina;
        } else {
            $totalPaginas = ($totalFilas / $totalFilasPagina) + 1;
        }
        if (empty($pagina) || $pagina > $totalPaginas) {
            $pagina = 1;
        }

        switch ($seleccionarParametro) {
            case 'numero':
                $publicaciones = $this->publicacionesPorNumeroPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo, $estado);
                break;
            case 'descripcion':
                $publicaciones = $this->publicacionesPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo, $estado);
                break;
            case 'fecha':
                $publicaciones = $this->publicacionesPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo, $estado);
                break;
            default:
                $publicaciones = $this->publicacionesPaginado($totalFilasPagina, $pagina, $tipo, $estado);
                break;
        }
        return ['publicaciones' => $publicaciones, 'totalFilas' => $totalFilas, 'totalFilasPagina' => $totalFilasPagina, 'totalPaginas' => $totalPaginas, 'pagina' => $pagina, 'seleccionarParametro' => $seleccionarParametro, 'valorParametro' => $valorParametro];
    }
    public function publicaciones($tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function publicacionesPorNumero($valorParametro, $tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_numero', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }    
    public function publicacionesPorDescripcion($valorParametro, $tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function publicacionesPorFecha($valorParametro, $tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function publicacionesPaginado($totalFilasPagina, $pagina, $tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('publicacion_numero')
        ->take($totalFilasPagina)
        ->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function publicacionesPorNumeroPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_numero', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('publicacion_numero')
        ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function publicacionesPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('publicacion_numero')
        ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function publicacionesPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo = null, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('publicacion_numero')
        ->take($totalFilasPagina)
        ->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function buscarAnuncios($totalFilasPagina, $pagina = null, $seleccionarParametro = null, $valorParametro = null, $estado = null, $usuarioId = null)
    {
        switch ($seleccionarParametro) {
            case 'tipo':
                if (empty($usuarioId)) {
                    $totalFilas = count($this->anunciosPorTipo($valorParametro, $estado));
                }
                else
                {
                    $totalFilas = count($this->anunciosPorUsuarioId($valorParametro, $estado, $usuarioId));
                }
                break;
            case 'descripcion':
                $totalFilas = count($this->anunciosPorDescripcion($valorParametro, $estado));
                break;
            case 'fecha':
                $totalFilas = count($this->anunciosPorFecha($valorParametro, $estado));
                break;
            default:
                $totalFilas = count($this->anuncios($estado));
                break;
        }

        if (($totalFilas % $totalFilasPagina) == 0) {
            $totalPaginas = $totalFilas / $totalFilasPagina;
        } else {
            $totalPaginas = ($totalFilas / $totalFilasPagina) + 1;
        }
        if (empty($pagina) || $pagina > $totalPaginas) {
            $pagina = 1;
        }

        switch ($seleccionarParametro) {
            case 'tipo':
                if (empty($usuarioId)) {
                    $publicaciones = $this->anunciosPorTipoPaginado($totalFilasPagina, $pagina, $valorParametro, $estado);
                    # code...
                } else {
                    $publicaciones = $this->anunciosPorUsuarioIdPaginado($totalFilasPagina, $pagina, $valorParametro, $estado, $usuarioId);
                }
                break;
            case 'descripcion':
                $publicaciones = $this->anunciosPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $estado);
                break;
            case 'fecha':
                $publicaciones = $this->anunciosPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $estado);
                break;
            default:
                $publicaciones = $this->anunciosPaginado($totalFilasPagina, $pagina, $estado);
                break;
        }
        return ['publicaciones' => $publicaciones, 'totalFilas' => $totalFilas, 'totalFilasPagina' => $totalFilasPagina, 'totalPaginas' => $totalPaginas, 'pagina' => $pagina, 'seleccionarParametro' => $seleccionarParametro, 'valorParametro' => $valorParametro];
    }
    public function anuncios($estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function anunciosPorUsuarioId($valorParametro, $estado = null, $usuarioId)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_tipo', $valorParametro)
        ->where('registrar_publ_usuario_id', $usuarioId)
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function anunciosPorTipo($valorParametro, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_tipo', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function anunciosPorDescripcion($valorParametro, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function anunciosPorFecha($valorParametro, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->get();
        return $publicaciones;
    }
    public function anunciosPaginado($totalFilasPagina, $pagina, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('registrar_publ_fecha')
        ->take($totalFilasPagina)
        ->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function anunciosPorUsuarioIdPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null, $usuarioId)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_tipo', $valorParametro)
        ->where('registrar_publ_usuario_id', $usuarioId)
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('registrar_publ_fecha')
        ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function anunciosPorTipoPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_tipo', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('registrar_publ_fecha')
        ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function anunciosPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('registrar_publ_fecha')
        ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function anunciosPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null)
    {
        $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
        ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
        ->where('registrar_publ_accion', $this->accion)
        ->where('publicacion_tipo', '<>', $this->comunicado)
        ->where('publicacion_tipo', '<>', $this->convocatoria)
        ->where('publicacion_estado', 'like', '%'.$estado.'%')
        ->orderByDesc('registrar_publ_fecha')
        ->take($totalFilasPagina)
        ->skip($totalFilasPagina * ($pagina - 1))
        ->get();
        return $publicaciones;
    }
    public function registrarPublicacion($tipo, $numero, $descripcion, $nombreArchivo, $archivo, $usuarioId)
    {
        DB::beginTransaction();
        try {
            $datos = [
                'publicacion_tipo' => $tipo,
                'publicacion_numero' => $numero,
                'publicacion_descripcion' => $descripcion,
                'publicacion_archivo' => $nombreArchivo,
                'publicacion_estado' => 1
            ];
            $publicaiconId = DB::table('publicaciones')->insertGetId($datos);
            
            $registro = [
                'registrar_publ_usuario_id' => $usuarioId,
                'registrar_publ_publicacion_id' => $publicaiconId,
                'registrar_publ_accion' => 'Insertar',
                'registrar_publ_fecha' => date('Y-m-d H:i:s')
            ];
            DB::table('registrar_publicaciones')->insert($registro);
            $tipo = strtolower($tipo).'s';
            $archivo->storeAs('publicaciones/'.$tipo.'/', $nombreArchivo, $this->disk);
            
            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
    public function actualizarPublicacion($tipo, $numero, $descripcion, $nombreArchivo, $archivo, $publicacionId, $usuarioId)
    {
        DB::beginTransaction();
        try {
            $nombreArchivoAnterior = DB::table('publicaciones')->where('publicacion_id', $publicacionId)->value('publicacion_archivo');
            $nombreArchivoActual = $publicacionId.'_'.$nombreArchivoAnterior;

            $datos = [
                'publicacion_archivo' => $nombreArchivoActual,
                'publicacion_estado' => 0
            ];
            DB::table('publicaciones')->where('publicacion_id', $publicacionId)->update($datos);
        
            $registro = [
                'registrar_publ_usuario_id' => $usuarioId,
                'registrar_publ_publicacion_id' => $publicacionId,
                'registrar_publ_accion' => 'Actualizar',
                'registrar_publ_fecha' => date('Y-m-d H:i:s')
            ];
            DB::table('registrar_publicaciones')->insert($registro);

            if (empty($archivo)) {
                $extension = pathinfo($nombreArchivoAnterior, PATHINFO_EXTENSION);
                $nombreArchivo = $nombreArchivo.'.'.$extension;
            }

            $datos = [
                'publicacion_tipo' => $tipo,
                'publicacion_numero' => $numero,
                'publicacion_descripcion' => $descripcion,
                'publicacion_archivo' => $nombreArchivo,
                'publicacion_estado' => 1
            ];
            $publicaiconId = DB::table('publicaciones')->insertGetId($datos);

            $registro = [
                'registrar_publ_usuario_id' => $usuarioId,
                'registrar_publ_publicacion_id' => $publicaiconId,
                'registrar_publ_accion' => 'Insertar',
                'registrar_publ_fecha' => date('Y-m-d H:i:s')
            ];
            DB::table('registrar_publicaciones')->insert($registro);
            Storage::disk($this->disk)->move('/publicaciones/anuncios/'.$nombreArchivoAnterior, '/publicaciones/anuncios/'.$nombreArchivoActual);
            if (empty($archivo)) {
                Storage::disk($this->disk)->copy('/publicaciones/anuncios/'.$nombreArchivoActual, '/publicaciones/anuncios/'.$nombreArchivo);
            }else{
                $archivo->storeAs('/publicaciones/anuncios/', $nombreArchivo, $this->disk);
            }
            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
    public function eliminarPublicacion($publicacionId, $usuarioId)
    {
        DB::beginTransaction();
        try {
            $nombreArchivoAnterior = DB::table('publicaciones')->where('publicacion_id', $publicacionId)->value('publicacion_archivo');
            $nombreArchivoActual = $publicacionId.'_'.$nombreArchivoAnterior;

            $datos = [
                'publicacion_archivo' => $nombreArchivoActual,
                'publicacion_estado' => 0
            ];
            DB::table('publicaciones')->where('publicacion_id', $publicacionId)->update($datos);
            
            $registro = [
                'registrar_publ_usuario_id' => $usuarioId,
                'registrar_publ_publicacion_id' => $publicacionId,
                'registrar_publ_accion' => 'Eliminar',
                'registrar_publ_fecha' => date('Y-m-d H:i:s')
            ];
            DB::table('registrar_publicaciones')->insert($registro);
            
            Storage::disk($this->disk)->move('/publicaciones/anuncios/'.$nombreArchivoAnterior, '/publicaciones/anuncios/'.$nombreArchivoActual);
            
            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
}
