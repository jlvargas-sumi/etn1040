<?php

namespace App\Http\Controllers\Usuario\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\PanelControl;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorPanelControlController extends Controller
{
    private $actividades;
    private $panelControl;
    private $carrera;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->panelControl = new PanelControl;
        $this->carrera = new Carrera;
    }
    public function indice()
    {
        $panelControl = $this->panelControl->panelControl();
        $planesEstudios = $this->carrera->planesEstudios();
        return view('usuario.administrador.panel-control', compact('panelControl', 'planesEstudios'));
    }
    public function habilitarApertura(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'plan_estudio_id' => 'required|integer',
            'gestion' => 'required|integer',
            'periodo' => 'required',
        ]);

        $gestion = $request->input('gestion');
        $periodo = $request->input('periodo');

        $actualizar = $this->panelControl->habilitarApertura($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Panel de Control',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Periodo "'.$periodo.'-'.$gestion.'" aperturado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Periodo "'.$periodo.'-'.$gestion.'" APERTURADO CORRECTAMENTE.'); 
            return to_route('administrador.panel-control');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Panel de Control',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al aperturar el periodo "'.$periodo.'-'.$gestion.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.panel-control');
    }
    public function habilitarInscripcion(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'gestion' => 'required|integer',
            'periodo' => 'required',
        ]);

        $id = $request->input('id');
        $gestion = $request->input('gestion');
        $periodo = $request->input('periodo');

        $actualizar = $this->panelControl->habilitarInscripcion($id);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Panel de Control',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Inscripción para el periodo "'.$periodo.'-'.$gestion.'" habilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Inscripción para el periodo "'.$periodo.'-'.$gestion.'" HABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.panel-control');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Panel de Control',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al habilitar la inscripción para el periodo "'.$periodo.'-'.$gestion.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.panel-control');
    }
    public function deshabilitarInscripcion(Request $request)
    {
        $request->validate(
            ['id' => 'required|integer', 'gestion' => 'required|integer', 'periodo' => 'required']
        );
        $id = $request->input('id');
        $gestion = $request->input('gestion');
        $periodo = $request->input('periodo');

        $actualizar = $this->panelControl->deshabilitarInscripcion($id);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Panel de Control',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Inscripción para el periodo "'.$periodo.'-'.$gestion.'" deshabilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Inscripción para el periodo "'.$periodo.'-'.$gestion.'" DESHABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.panel-control');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Panel de Control',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al deshabilitar la inscripción para el periodo "'.$periodo.'-'.$gestion.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.panel-control');
    }
    public function habilitarPeriodo(Request $request)
    {
        $request->validate(
            ['id' => 'required|integer', 'gestion' => 'required|integer', 'periodo' => 'required']
        );
        $id = $request->input('id');
        $gestion = $request->input('gestion');
        $periodo = $request->input('periodo');

        $actualizar = $this->panelControl->habilitarPeriodo($id);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Panel de Control',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Estado del periodo "'.$periodo.'-'.$gestion.'" actualizado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Estado del periodo "'.$periodo.'-'.$gestion.'" ACTUALIZADO CORRECTAMENTE.'); 
            return to_route('administrador.panel-control');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Panel de Control',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar el estado del periodo "'.$periodo.'-'.$gestion.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.panel-control');
    }
}
