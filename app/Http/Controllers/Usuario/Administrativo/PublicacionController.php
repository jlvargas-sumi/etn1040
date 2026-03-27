<?php

namespace App\Http\Controllers\Usuario\Administrativo;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Publicacion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicacionController extends Controller
{
    private $actividades;
    private $publicaciones;
    private $estado = 1;
    private $tipo = 'Comunicado';

    public function __construct()
    {
        $this->actividades = new Actividad();
        $this->publicaciones = new Publicacion;
    }

    public function indice($tipo = null)
    {
        $usuarioId = Auth::User()->usuario_id;
        $tipo = $tipo ?? $this->tipo;

        $publicaciones = $this->publicaciones->publicacionesPorTipo($tipo, $this->estado);
        $anuncios = $this->publicaciones->anunciosPorTipo(null, $this->estado);
        $publicaciones = $tipo == 'Anuncio' ? $anuncios : $publicaciones;
        return view('usuario.administrativo.publicaciones', compact('publicaciones', 'tipo'));
    }
    public function publicar(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'archivo' => 'required|max:2048',
            'tipo' => 'required'
        ]);
        $usuarioId = Auth::User()->usuario_id;
        $numero = $request->input('numero');
        $titulo = $request->input('titulo');
        $archivo = $request->file('archivo');
        $tipo = $request->input('tipo');
               
        $publicar = $this->publicaciones->registrarPublicacion($tipo, $numero, $titulo, $archivo, $usuarioId);
        
        if ($publicar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos - Publicaciones',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Publicación "'.$titulo.'" realizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Publicación "'.$titulo.'" REALIZADA CORRECTAMENTE.');
            return to_route('administrativo.publicaciones', $tipo);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos - Publicaciones',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al realizar la publicación "'.$titulo.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrativo.publicaciones', $tipo);
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'publicacion_id' => 'required',
            'actualizar_titulo' => 'required',
            'otro_archivo' => 'required',
            'actualizar_archivo' => 'sometimes|required_if:otro_archivo,1|required|max:2048'
        ]);
        $usuarioId = Auth::User()->usuario_id;
        $tipo = $request->input('tipo');
        $tipoAnuncio = $request->input('actualizar_tipo_anuncio');
        $_tipo = $tipoAnuncio ? $tipoAnuncio : $tipo;
        $publicacionId = $request->input('publicacion_id');
        $numero = $request->input('actualizar_numero');
        $titulo = $request->input('actualizar_titulo');
        $archivo = $request->file('actualizar_archivo');
        
        if (!empty($archivo)) {
            $nombreArchivo = $numero.'.'.$archivo->extension();
        }

        $actualizar = $this->publicaciones->actualizarPublicacion($_tipo, $numero, $titulo, $nombreArchivo ?? null, $archivo, $publicacionId, $usuarioId);

        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos - Publicaciones',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Publicación "'.$titulo.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Publicación "'.$titulo.'" ACTUALIZADA CORRECTAMENTE.');
            return to_route('administrativo.publicaciones', $tipo);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos - Publicaciones',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar la publicación "'.$titulo.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrativo.publicaciones', $tipo);  
    }
    public function eliminar(Request $request)
    {
        $request->validate([
            'publicacion_id' => 'required', 
            'titulo' => 'required',
            'tipo' => 'required'
        ]);

        $usuarioId = Auth::User()->usuario_id;

        $publicacionId = $request->input('publicacion_id');
        $titulo = $request->input('titulo');
        $tipo = $request->input('tipo');

        $eliminar = $this->publicaciones->eliminarPublicacion($publicacionId, $usuarioId);

        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Administrativos - Publicaciones',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Publicación "'.$titulo.'" eliminada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Publicación "'.$titulo.'" ELIMINADA EXITOSAMENTE.');
            return to_route('administrativo.publicaciones', $tipo);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Administrativos - Publicaciones',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar la publicación "'.$titulo.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrativo.publicaciones', $tipo);
    }
}
