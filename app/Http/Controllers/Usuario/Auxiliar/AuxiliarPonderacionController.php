<?php

namespace App\Http\Controllers\Usuario\Auxiliar;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Asignatura;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuxiliarPonderacionController extends Controller
{
    private $actividades;
    private $asignaturas;
    private $panelControl;

    private $personaId;
    
    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->asignaturas = new Asignatura;
        $this->panelControl = new PanelControl;

        $this->personaId = Auth::User()->usuario_persona_id;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($aperturaId, $periodo = null, $gestion = null)
    {
        $verificarMiAperturaId = $this->asignaturas->verificarMiAperturaIdAuxiliar($aperturaId, $this->personaId, $periodo, $gestion);
        if (!$verificarMiAperturaId) {
            return to_route('auxiliar.auxiliaturas', [$periodo, $gestion]);
        }

        $aperturas = $this->asignaturas->aperturasAuxiliaturaPorPersonaAperturaId($this->personaId, $aperturaId);
        $asignatura = $this->asignaturas->asignaturaPorAperturaId($aperturaId);
        
        return view('usuario.auxiliar.ponderaciones', compact('aperturas', 'asignatura', 'aperturaId', 'periodo', 'gestion'));
    }
    public function crear(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'apertura_id' => 'required|integer',
            'ponderacion' => 'required|numeric',
            'tipo' => 'required',
            'tipo_es' => 'required',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $tipo = $request->input('tipo_es');
        $aperturaId = $request->input('apertura_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->crearPonderacionAuxiliatura($request);
        if ($crear) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares - Ponderaciones',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Ponderación para "'.$tipo.'" de la asignatura "'.$sigla.'" creada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Ponderación para "'.$tipo.'" de la asignatura "'.$sigla.'" CREADA CORRECTAMENTE.');
            return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares - Ponderaciones',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al crear ponderación para "'.$tipo.'" de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);

    }
    public function eliminar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'apertura_id' => 'required|integer',
            'indice' => 'required',
            'tipo' => 'required',
            'tipo_es' => 'required',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $tipo = $request->input('tipo_es');
        $indice = $request->input('indice');
        $aperturaId = $request->input('apertura_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');
        
        $eliminar = $this->asignaturas->eliminarPonderacionAuxiliatura($request);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares - Ponderaciones',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Ponderación "'.$indice.'" para "'.$tipo.'" de la asignatura "'.$sigla.'" eliminada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Ponderación "'.$indice.'" para "'.$tipo.'" de la asignatura "'.$sigla.'" ELIMINADA CORRECTAMENTE.');
            return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares - Ponderaciones',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar ponderación "'.$indice.'" para "'.$tipo.'" de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);

    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'apertura_id' => 'required|integer',
            'ponderaciones' => 'required',
            'tipo' => 'required',
            'tipo_es' => 'required',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $tipo = $request->input('tipo_es');
        $aperturaId = $request->input('apertura_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->actualizarPonderacionAuxiliatura($request);
        if ($crear) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares - Ponderaciones',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Ponderación para "'.$tipo.'" de la asignatura "'.$sigla.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Ponderación para "'.$tipo.'" de la asignatura "'.$sigla.'" ACTUALIZADA CORRECTAMENTE.');
            return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares - Ponderaciones',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar ponderación para "'.$tipo.'" de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);
    }
    public function actualizarApertura(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'ponderacion_principal' => 'required|numeric',
            'ponderacion_secundaria' => 'required|numeric',
            'campo' => 'required',
            'apertura_id' => 'required|integer',
            'periodo' => 'required',
            'gestion' => 'required|integer',
            'sigla' => 'required',
        ]);
        $campo = $request->input('campo');
        $aperturaId = $request->input('apertura_id');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        $sigla = $request->input('sigla');

        $crear = $this->asignaturas->actualizarPonderacionAuxiliaturaApertura($request);
        if ($crear) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Auxiliares - Ponderaciones',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Ponderación general para "'.$campo.'" de la asignatura "'.$sigla.'" actualizada correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Ponderación general para "'.$campo.'" de la asignatura "'.$sigla.'" ACTUALIZADA CORRECTAMENTE.');
            return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Auxiliares - Ponderaciones',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al actualizar ponderación general para "'.$campo.'" de la asignatura "'.$sigla.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion]);
    }
}