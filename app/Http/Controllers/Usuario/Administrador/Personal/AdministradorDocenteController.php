<?php

namespace App\Http\Controllers\Usuario\Administrador\Personal;

use App\Http\Controllers\Controller;

use App\Models\Actividad;
use App\Models\Plantel;
use App\Models\PanelControl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorDocenteController extends Controller
{
    private $actividades;
    private $plantel;
    private $panelControl;

    private $periodo;
    private $gestion;

    public function __construct()
    {
        $this->actividades = new Actividad;
        $this->plantel = new Plantel;
        $this->panelControl = new PanelControl;

        $panelControl = $this->panelControl->panelControlActual();
        $this->periodo = $panelControl->periodo_nombre;
        $this->gestion = $panelControl->periodo_gestion;
    }

    public function indice($ci = null)
    {
        $docentes = $this->plantel->informacionPersonalDocentesPorCi($ci);
        $categorias = $this->plantel->categorias();
        return view('usuario.administrador.personal.administrar-docentes', compact(
            'docentes','ci','categorias'
        ));
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'ci' => 'required',
            // 'primer_apellido' => 'nullable|alpha',
            // 'segundo_apellido' => 'nullable|alpha',
            'nombres' => 'required',
            'celular' => 'required|integer',
            'correo' => 'required',
            'categoria_id' => 'required|integer'
        ]);
        $ci = $request->input('ci');

        $actualizar = $this->plantel->actualizarInformacionPersonalDocente($request);
        if ($actualizar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Datos del docente con C.I. "'.$ci.'" actualizados correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Datos del docente con C.I. "'.$ci.'" ACTUALIZADOS CORRECTAMENTE.'); 
            return to_route('administrador.docentes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes',
            $accion = 3,
            $resultado = 1,
            $descripcion = 'Error al actualizar los datos del docente con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.docentes');
    }
    public function agregar(Request $request)
    {
        $request->validate(['ci'=>'required', 'categoria_id' => 'required|integer', 'grado' => 'required']);
        $ci = $request->input('ci');
        $categoriaId = $request->input('categoria_id');
        $grado = $request->input('grado');

        $agregar = $this->plantel->agregarDocentePorCi($ci, $categoriaId, $grado);
        if ($agregar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes',
                $accion = 1,
                $resultado = 1,
                $descripcion = 'Usuario con C.I. "'.$ci.'" agregado como docente correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Usuario con C.I. "'.$ci.'" AGREGADO COMO DOCENTE CORRECTAMENTE.'); 
            return to_route('administrador.docentes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes',
            $accion = 1,
            $resultado = 2,
            $descripcion = 'Error al agregar como docente al usuario con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.docentes');
    }
    public function eliminar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $eliminar = $this->plantel->eliminarDocente($id);
        if ($eliminar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes',
                $accion = 4,
                $resultado = 1,
                $descripcion = 'Docente con C.I. "'.$ci.'" eliminado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Docente con C.I. "'.$ci.'" ELIMINADO CORRECTAMENTE.'); 
            return to_route('administrador.docentes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes',
            $accion = 4,
            $resultado = 2,
            $descripcion = 'Error al eliminar al docente con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.docentes');
    }
    public function inhabilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $inhabilitar = $this->plantel->inhabilitarDocente($id);
        if ($inhabilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Docente con C.I. "'.$ci.'" inhabilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Docente con C.I. "'.$ci.'" INHABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.docentes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al inhabilitar al docente con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.docentes');
    }
    public function habilitar(Request $request)
    {
        $request->validate(['id' => 'required|integer', 'ci'=>'required']);
        $id = $request->input('id');
        $ci = $request->input('ci');

        $habilitar = $this->plantel->habilitarDocente($id);
        if ($habilitar) {
            $this->actividades->registrarActividad(
                Auth::User()->usuario_id,
                $modulo = 'Docentes',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Docente con C.I. "'.$ci.'" habilitado correctamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('exito', 'Docente con C.I. "'.$ci.'" HABILITADO CORRECTAMENTE.'); 
            return to_route('administrador.docentes');
        }
        $this->actividades->registrarActividad(
            Auth::User()->usuario_id,
            $modulo = 'Docentes',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al habilitar al docente con C.I. "'.$ci.'".',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.'); 
        return to_route('administrador.docentes');
    }
}
