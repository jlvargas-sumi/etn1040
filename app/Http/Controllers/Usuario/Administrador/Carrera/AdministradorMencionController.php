<?php

namespace App\Http\Controllers\Usuario\Administrador\Carrera;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Carrera;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorMencionController extends Controller
{
    private $actividades;
    private $carrera;
    private $panelControl;

    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->carrera = new Carrera;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice()
    {
        $menciones = $this->carrera->menciones();
        return view('usuario.administrador.carrera.administrar-menciones', compact(
            'menciones'
        ));
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'mencion' => 'required',
        ]);
        $mencion = $request->input('mencion');

        $actualizar = $this->carrera->actualizarMencion($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Menciones',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Mención "'.$mencion.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos de mención "'.$mencion.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.menciones');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Menciones',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Mención "'.$mencion.'" actualizada correctamente.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.menciones');
    }
    public function crear(Request $request)
    {
        $request->validate([
            'mencion' => ['required'],
        ]);

        $mencion = $request->input('mencion');

        $agregar = $this->carrera->crearMencion($request);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Menciones',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Mención "'.$mencion.'" creada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Mención "'.$mencion.'" CREADO CORRECTAMENTE.'); 
            return to_route('administrador.menciones');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Menciones',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al crear la mención "'.$mencion.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.menciones');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'mencion'=>'required']);
        $id = $request->input('id');
        $mencion = $request->input('mencion');

        $eliminar = $this->carrera->eliminarMencion($id);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Menciones',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Mención "'.$mencion.'" eliminada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Mención "'.$mencion.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.menciones');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Menciones',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar la mención "'.$mencion.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.menciones');
    }
}
