<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Publicacion extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'publicaciones';
    protected $primaryKey = 'publicacion_id';
    public $timestamps = false;

    private $accion = 'Insertar';
    private $comunicado = 'Comunicado';
    private $convocatoria = 'Convocatoria';
    private $anuncio = 'Anuncio';
    private $disk = "public";

    public function publicacionesPorTipo($tipo, $estado)
    {
        $sub = DB::table('registrar_publicaciones')
            ->select('registrar_publ_publicacion_id', DB::raw('MAX(registrar_publ_fecha) as max_fecha'))
            ->groupBy('registrar_publ_publicacion_id');

        $publicaciones = Publicacion::joinSub($sub, 'rp_max', function($join) {
                $join->on('publicacion_id', '=', 'rp_max.registrar_publ_publicacion_id');
            })
            ->join('registrar_publicaciones as rp', function($join) {
                $join->on('publicacion_id', '=', 'rp.registrar_publ_publicacion_id')
                     ->on('rp.registrar_publ_fecha', '=', 'rp_max.max_fecha');
            })
            ->where('publicacion_tipo', $tipo)
            ->where('publicacion_tipo', '<>', $this->anuncio)
            ->where('publicacion_estado', $estado)
            // ->orderByDesc('publicacion_numero')
            ->orderByDesc('rp.registrar_publ_fecha')
            ->get();

        return $publicaciones;
    }
    public function anunciosPorTipo($tipo, $estado)
    {
        $sub = DB::table('registrar_publicaciones')
            ->select('registrar_publ_publicacion_id', DB::raw('MAX(registrar_publ_fecha) as max_fecha'))
            ->groupBy('registrar_publ_publicacion_id');

        $anuncios = Publicacion::joinSub($sub, 'rp_max', function($join) {
                $join->on('publicacion_id', '=', 'rp_max.registrar_publ_publicacion_id');
            })
            ->join('registrar_publicaciones as rp', function($join) {
                $join->on('publicacion_id', '=', 'rp.registrar_publ_publicacion_id')
                     ->on('rp.registrar_publ_fecha', '=', 'rp_max.max_fecha');
            })
            ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
            ->where('publicacion_tipo', '<>', $this->comunicado)
            ->where('publicacion_tipo', '<>', $this->convocatoria)
            ->where('publicacion_tipo', '<>', 'Docencia')
            ->where('publicacion_tipo', '<>', 'Auxiliatura')
            ->where('publicacion_estado', $estado)
            // ->orderByDesc('publicacion_numero')
            ->orderByDesc('rp.registrar_publ_fecha')
            ->get();

        return $anuncios;
    }
    public function anuncios($estado)
    {
        $sub = DB::table('registrar_publicaciones')
            ->select('registrar_publ_publicacion_id', DB::raw('MAX(registrar_publ_fecha) as max_fecha'))
            ->groupBy('registrar_publ_publicacion_id');

        $anuncios = Publicacion::joinSub($sub, 'rp_max', function($join) {
                $join->on('publicacion_id', '=', 'rp_max.registrar_publ_publicacion_id');
            })
            ->join('registrar_publicaciones as rp', function($join) {
                $join->on('publicacion_id', '=', 'rp.registrar_publ_publicacion_id')
                     ->on('rp.registrar_publ_fecha', '=', 'rp_max.max_fecha');
            })
            ->where('publicacion_tipo', '<>', $this->comunicado)
            ->where('publicacion_tipo', '<>', $this->convocatoria)
            ->where('publicacion_estado', $estado)
            // ->orderByDesc('publicacion_numero')
            ->orderByDesc('rp.registrar_publ_fecha')
            ->get();

        return $anuncios;
    }
    public function misAnuncios($usuarioId, $estado)
    {
        $sub = DB::table('registrar_publicaciones')
            ->select('registrar_publ_publicacion_id', DB::raw('MAX(registrar_publ_fecha) as max_fecha'))
            ->where('registrar_publ_usuario_id', $usuarioId)
            ->groupBy('registrar_publ_publicacion_id');

        $publicaciones = Publicacion::joinSub($sub, 'rp_max', function($join) {
                $join->on('publicacion_id', '=', 'rp_max.registrar_publ_publicacion_id');
            })
            ->join('registrar_publicaciones as rp', function($join) {
                $join->on('publicacion_id', '=', 'rp.registrar_publ_publicacion_id')
                     ->on('rp.registrar_publ_fecha', '=', 'rp_max.max_fecha');
            })
            ->where('publicacion_tipo', '<>', $this->comunicado)
            ->where('publicacion_tipo', '<>', $this->convocatoria)
            ->where('rp.registrar_publ_usuario_id', $usuarioId)
            ->where('publicacion_estado', $estado)
            // ->orderByDesc('publicacion_numero')
            ->orderByDesc('rp.registrar_publ_fecha')
            ->get();

        return $publicaciones;
    }
















    // public function buscarPublicaciones($totalFilasPagina, $pagina = null, $seleccionarParametro = null, $valorParametro = null, $tipo = null, $estado = null)
    // {
    //     switch ($seleccionarParametro) {
    //         case 'numero':
    //             $totalFilas = count($this->publicacionesPorNumero($valorParametro, $tipo, $estado));
    //             break;
    //         case 'descripcion':
    //             $totalFilas = count($this->publicacionesPorDescripcion($valorParametro, $tipo, $estado));
    //             break;
    //         case 'fecha':
    //             $totalFilas = count($this->publicacionesPorFecha($valorParametro, $tipo, $estado));
    //             break;
    //         default:
    //             $totalFilas = count($this->publicaciones($tipo, $estado));
    //             break;
    //     }

    //     if (($totalFilas % $totalFilasPagina) == 0) {
    //         $totalPaginas = $totalFilas / $totalFilasPagina;
    //     } else {
    //         $totalPaginas = ($totalFilas / $totalFilasPagina) + 1;
    //     }
    //     if (empty($pagina) || $pagina > $totalPaginas) {
    //         $pagina = 1;
    //     }

    //     switch ($seleccionarParametro) {
    //         case 'numero':
    //             $publicaciones = $this->publicacionesPorNumeroPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo, $estado);
    //             break;
    //         case 'descripcion':
    //             $publicaciones = $this->publicacionesPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo, $estado);
    //             break;
    //         case 'fecha':
    //             $publicaciones = $this->publicacionesPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo, $estado);
    //             break;
    //         default:
    //             $publicaciones = $this->publicacionesPaginado($totalFilasPagina, $pagina, $tipo, $estado);
    //             break;
    //     }
    //     return ['publicaciones' => $publicaciones, 'totalFilas' => $totalFilas, 'totalFilasPagina' => $totalFilasPagina, 'totalPaginas' => $totalPaginas, 'pagina' => $pagina, 'seleccionarParametro' => $seleccionarParametro, 'valorParametro' => $valorParametro];
    // }
    // public function publicaciones($tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }
    // public function publicacionesPorNumero($valorParametro, $tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_numero', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }    
    // public function publicacionesPorDescripcion($valorParametro, $tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }
    // public function publicacionesPorFecha($valorParametro, $tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }
    // public function publicacionesPaginado($totalFilasPagina, $pagina, $tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('publicacion_numero')
    //     ->take($totalFilasPagina)
    //     ->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function publicacionesPorNumeroPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_numero', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('publicacion_numero')
    //     ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function publicacionesPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('publicacion_numero')
    //     ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function publicacionesPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $tipo = null, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', 'like', '%'.$tipo.'%')
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('publicacion_numero')
    //     ->take($totalFilasPagina)
    //     ->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function buscarAnuncios($totalFilasPagina, $pagina = null, $seleccionarParametro = null, $valorParametro = null, $estado = null, $usuarioId = null)
    // {
    //     switch ($seleccionarParametro) {
    //         case 'tipo':
    //             if (empty($usuarioId)) {
    //                 $totalFilas = count($this->anunciosPorTipo($valorParametro, $estado));
    //             }
    //             else
    //             {
    //                 $totalFilas = count($this->anunciosPorUsuarioId($valorParametro, $estado, $usuarioId));
    //             }
    //             break;
    //         case 'descripcion':
    //             $totalFilas = count($this->anunciosPorDescripcion($valorParametro, $estado));
    //             break;
    //         case 'fecha':
    //             $totalFilas = count($this->anunciosPorFecha($valorParametro, $estado));
    //             break;
    //         default:
    //             $totalFilas = count($this->anuncios($estado));
    //             break;
    //     }

    //     if (($totalFilas % $totalFilasPagina) == 0) {
    //         $totalPaginas = $totalFilas / $totalFilasPagina;
    //     } else {
    //         $totalPaginas = ($totalFilas / $totalFilasPagina) + 1;
    //     }
    //     if (empty($pagina) || $pagina > $totalPaginas) {
    //         $pagina = 1;
    //     }

    //     switch ($seleccionarParametro) {
    //         case 'tipo':
    //             if (empty($usuarioId)) {
    //                 $publicaciones = $this->anunciosPorTipoPaginado($totalFilasPagina, $pagina, $valorParametro, $estado);
    //                 # code...
    //             } else {
    //                 $publicaciones = $this->anunciosPorUsuarioIdPaginado($totalFilasPagina, $pagina, $valorParametro, $estado, $usuarioId);
    //             }
    //             break;
    //         case 'descripcion':
    //             $publicaciones = $this->anunciosPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $estado);
    //             break;
    //         case 'fecha':
    //             $publicaciones = $this->anunciosPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $estado);
    //             break;
    //         default:
    //             $publicaciones = $this->anunciosPaginado($totalFilasPagina, $pagina, $estado);
    //             break;
    //     }
    //     return ['publicaciones' => $publicaciones, 'totalFilas' => $totalFilas, 'totalFilasPagina' => $totalFilasPagina, 'totalPaginas' => $totalPaginas, 'pagina' => $pagina, 'seleccionarParametro' => $seleccionarParametro, 'valorParametro' => $valorParametro];
    // }
    // public function anuncios($estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', '<>', $this->comunicado)
    //     ->where('publicacion_tipo', '<>', $this->convocatoria)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPorUsuarioId($valorParametro, $estado = null, $usuarioId)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_tipo', $valorParametro)
    //     ->where('registrar_publ_usuario_id', $usuarioId)
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPorDescripcion($valorParametro, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', '<>', $this->comunicado)
    //     ->where('publicacion_tipo', '<>', $this->convocatoria)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPorFecha($valorParametro, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', '<>', $this->comunicado)
    //     ->where('publicacion_tipo', '<>', $this->convocatoria)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPaginado($totalFilasPagina, $pagina, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', '<>', $this->comunicado)
    //     ->where('publicacion_tipo', '<>', $this->convocatoria)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('registrar_publ_fecha')
    //     ->take($totalFilasPagina)
    //     ->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPorUsuarioIdPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null, $usuarioId)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_tipo', $valorParametro)
    //     ->where('registrar_publ_usuario_id', $usuarioId)
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('registrar_publ_fecha')
    //     ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPorTipoPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_tipo', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', '<>', $this->comunicado)
    //     ->where('publicacion_tipo', '<>', $this->convocatoria)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('registrar_publ_fecha')
    //     ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPorDescripcionPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('publicacion_descripcion', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', '<>', $this->comunicado)
    //     ->where('publicacion_tipo', '<>', $this->convocatoria)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('registrar_publ_fecha')
    //     ->take($totalFilasPagina)->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    // public function anunciosPorFechaPaginado($totalFilasPagina, $pagina, $valorParametro, $estado = null)
    // {
    //     $publicaciones = DB::table('publicaciones')->join('registrar_publicaciones', 'publicacion_id', '=', 'registrar_publ_publicacion_id')
    //     ->where('registrar_publ_fecha', 'like', '%'.$valorParametro.'%')
    //     ->where('registrar_publ_accion', $this->accion)
    //     ->where('publicacion_tipo', '<>', $this->comunicado)
    //     ->where('publicacion_tipo', '<>', $this->convocatoria)
    //     ->where('publicacion_estado', 'like', '%'.$estado.'%')
    //     ->orderByDesc('registrar_publ_fecha')
    //     ->take($totalFilasPagina)
    //     ->skip($totalFilasPagina * ($pagina - 1))
    //     ->get();
    //     return $publicaciones;
    // }
    public function registrarPublicacion($tipo, $numero, $titulo, $archivo, $usuarioId)
    {
        $numero = $numero ? $numero : date('YmdHis').'.'.rand(1000, 9999);
        $fecha = date('Y-m-d H:i:s');
        $nombreArchivo = $numero.'.'.$archivo->extension();
        
        DB::beginTransaction();
        try {
            $datos = [
                'publicacion_tipo' => $tipo,
                'publicacion_numero' => $numero,
                'publicacion_titulo' => $titulo,
                'publicacion_archivo' => $nombreArchivo,
                'publicacion_estado' => 1
            ];
            $publicacion = Publicacion::create($datos);
            $publicacionId = $publicacion->publicacion_id;

            $registro = [
                'registrar_publ_usuario_id' => $usuarioId,
                'registrar_publ_publicacion_id' => $publicacionId,
                'registrar_publ_archivo' => $nombreArchivo,
                'registrar_publ_accion' => 'Insertar',
                'registrar_publ_fecha' => $fecha
            ];
            $publicacion = RegistrarPublicacion::create($registro);

            switch ($tipo) {
                case 'Comunicado':
                    $tipo = 'comunicados';
                    break;
                case 'Convocatoria':
                    $tipo = 'convocatorias';
                    break;
                
                default:
                    $tipo = 'anuncios';
                    break;
            }
            $archivo->storeAs('publicaciones/'.$tipo.'/', $nombreArchivo, $this->disk);
            
            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
    public function actualizarPublicacion($tipo, $numero, $titulo, $nombreArchivo, $archivo, $publicacionId, $usuarioId)
    {
        $tipoAnuncio = $tipo;
        switch ($tipo) {
            case 'Comunicado':
                $tipo = 'comunicados';
                break;
            case 'Convocatoria':
                $tipo = 'convocatorias';
                break;
            
            default:
                $tipo = 'anuncios';
                break;
        }

        DB::beginTransaction();
        try {
            $publicacionAnterior = Publicacion::where('publicacion_id', $publicacionId)->first();
            $nombreArchivoAnterior = $publicacionAnterior->publicacion_archivo;
            $ext = pathinfo($nombreArchivoAnterior, PATHINFO_EXTENSION);
            $numero = $numero ? $numero : date('YmdHis').'.'.rand(1000, 9999);
            $nombreArchivoRenovado = $numero.'.'.strtolower($ext);
            $nombreArchivo = $nombreArchivo ? $nombreArchivo : $nombreArchivoRenovado;

            $registro = [
                'registrar_publ_usuario_id' => $usuarioId,
                'registrar_publ_publicacion_id' => $publicacionId,
                'registrar_publ_archivo' => $nombreArchivo,
                'registrar_publ_accion' => 'Actualizar',
                'registrar_publ_fecha' => date('Y-m-d H:i:s')
            ];
            RegistrarPublicacion::create($registro);

            $datos = [
                'publicacion_tipo' => $tipoAnuncio,
                'publicacion_numero' => $numero,
                'publicacion_titulo' => $titulo,
                'publicacion_archivo' => $nombreArchivo,
                'publicacion_estado' => 1
            ];
            Publicacion::where('publicacion_id', $publicacionId)->update($datos);

            if (!empty($archivo)) {
                $archivo->storeAs('publicaciones/'.$tipo.'/', $nombreArchivo, $this->disk);
            } 
            else{
                if (Storage::disk($this->disk)->exists('publicaciones/'.$tipo.'/'.$publicacionAnterior->publicacion_archivo)) {
                    Storage::disk($this->disk)->move('publicaciones/'.$tipo.'/'.$publicacionAnterior->publicacion_archivo, 'publicaciones/'.$tipo.'/'.$nombreArchivo);
                }
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
            $fecha = date('Y-m-d H:i:s');
            $numero = date('YmdHis').'.'.rand(1000, 9999);

            $publicacion = Publicacion::where('publicacion_id', $publicacionId)->first();
            $nombreArchivo = $publicacion->publicacion_archivo;
            $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nombreArchivo = $numero.'.'.strtolower($ext);

            $datos = [
                'publicacion_numero' => $numero,
                'publicacion_archivo' => $nombreArchivo,
                'publicacion_estado' => 0
            ];
            Publicacion::where('publicacion_id', $publicacionId)->update($datos);
            $publicacion = Publicacion::where('publicacion_id', $publicacionId)->first();
            $nombreArchivo = $publicacion->publicacion_archivo;
            
            $registro = [
                'registrar_publ_usuario_id' => $usuarioId,
                'registrar_publ_publicacion_id' => $publicacionId,
                'registrar_publ_archivo' => $nombreArchivo,
                'registrar_publ_accion' => 'Eliminar',
                'registrar_publ_fecha' => $fecha
            ];
            RegistrarPublicacion::create($registro);
            
            DB::commit();
            return true;
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
}
