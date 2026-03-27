<?php

namespace App\Http\Controllers\Usuario\Administrador\Carrera;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Carrera;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorAulaController extends Controller
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

    public function indice($ci = null)
    {
        $aulas = $this->carrera->aulas();
        return view('usuario.administrador.carrera.administrar-aulas', compact(
            'aulas'
        ));
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'aula' => 'required',
            'capacidad' => 'required|integer',
        ]);
        $aula = $request->input('aula');

        $actualizar = $this->carrera->actualizarAula($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aulas',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Aula "'.$aula.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos de aula "'.$aula.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.aulas');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aulas',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar el aula "'.$aula.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aulas');
    }
    public function crear(Request $request)
    {
        $request->validate([
            'aula' => 'required',
            'capacidad' => 'required|integer',
        ]);

        $aula = $request->input('aula');

        $agregar = $this->carrera->crearAula($request);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aulas',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Aula "'.$aula.'" creada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Aula "'.$aula.'" CREADO CORRECTAMENTE.'); 
            return to_route('administrador.aulas');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aulas',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al crear el aula "'.$aula.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aulas');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'aula'=>'required']);
        $id = $request->input('id');
        $aula = $request->input('aula');

        $eliminar = $this->carrera->eliminarAula($id);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Aulas',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Aula "'.$aula.'" eliminada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Aula "'.$aula.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.aulas');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Aulas',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar el aula "'.$aula.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.aulas');
    }
}
