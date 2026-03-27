<?php

namespace App\Http\Controllers\Usuario\Docente;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Publicacion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteAnuncioController extends Controller
{
    private $actividades;
    private $publicaciones;
    private $estado = 1;
    private $tipo = 'Docencia';

    public function __construct()
    {
        $this->actividades = new Actividad();
        $this->publicaciones = new Publicacion;
    }

    public function indice()
    {
        $usuarioId = Auth::User()->usuario_id;

        $anuncios = $this->publicaciones->misAnuncios($usuarioId, $this->estado);
        
        return view('usuario.docente.anuncios', compact('anuncios'));
    }
    public function publicar(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'asignatura' => 'required',
            'archivo' => 'required|max:2048'
        ]);

        $usuarioId = Auth::User()->usuario_id;
        $asignatura = $request->input('asignatura');
        $titulo = $request->input('titulo').' ('.$asignatura.')';
        $archivo = $request->file('archivo');
               
        $publicarAnuncio = $this->publicaciones->registrarPublicacion($this->tipo, null, $titulo, $archivo, $usuarioId);
        
        if ($publicarAnuncio) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes - Anuncios',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Anuncio "'.$titulo.'" para la asignatura "'.$asignatura.'" publicado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Anuncio "'.$titulo.'" para la asignatura "'.$asignatura.'" PUBLICADO CORRECTAMENTE.');
            return to_route('docente.anuncios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes - Anuncios',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al publicar el anuncio "'.$titulo.'" para la asignatura "'.$asignatura.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('docente.anuncios');
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'publicacion_id' => 'required',
            'actualizar_titulo' => 'required',
            'actualizar_asignatura' => 'required',
            'otro_archivo' => 'required',
            'actualizar_archivo' => 'sometimes|required_if:otro_archivo,1|required|max:2048'
        ]);

        $usuarioId = Auth::User()->usuario_id;
        $publicacionId = $request->input('publicacion_id');
        $asignatura = $request->input('actualizar_asignatura');
        $titulo = $request->input('actualizar_titulo').' ('.$asignatura.')';
        $archivo = $request->file('actualizar_archivo');
        $numero = date('YmdHis').'.'.rand(1000, 9999);
        
        if (!empty($archivo)) {
            $nombreArchivo = $numero.'.'.$archivo->extension();
        }

        $actualizar = $this->publicaciones->actualizarPublicacion($this->tipo, $numero, $titulo, $nombreArchivo ?? null, $archivo, $publicacionId, $usuarioId);

        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes - Anuncios',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Anuncio "'.$titulo.'" para la asignatura "'.$asignatura.'" actualizado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Anuncio "'.$titulo.'" para la asignatura "'.$asignatura.'" ACTUALIZADO CORRECTAMENTE.');
            return to_route('docente.anuncios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes - Anuncios',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar el anuncio "'.$titulo.'" para la asignatura "'.$asignatura.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('docente.anuncios');  
    }
    public function eliminar(Request $request)
    {
        $request->validate(['publicacion_id' => 'required', 'descripcion' => 'required']);

        $usuarioId = Auth::User()->usuario_id;

        $publicacionId = $request->input('publicacion_id');
        $descripcion = $request->input('descripcion');

        $descripcion = explode('(', $descripcion);
        $titulo = trim($descripcion[0]);
        $sigla = trim(str_replace(')', '', $descripcion[1]));

        $eliminar = $this->publicaciones->eliminarPublicacion($publicacionId, $usuarioId);

        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes - Anuncios',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Anuncio "'.$titulo.'" para la asignatura "'.$sigla.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Anuncio "'.$descripcion.'" eliminado exitosamente.');
            return to_route('docente.anuncios');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes - Anuncios',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar el anuncio "'.$titulo.'" para la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('docente.anuncios');
    }
}
