<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\CodigoCorreoRequest;

use App\Models\DatoUsuarioAutenticado;
use App\Models\Actividad;

class SolicitudCodigoCorreoController extends Controller
{
    private $datosUsuariosAutenticados;
    private $actividades;

    public function __construct()
    {
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
        $this->actividades = new Actividad;
    }

    public function indice()
    {
        return view('auth.solicitud-codigo-correo');
    }

    public function almacenar(CodigoCorreoRequest $request)
    {
        $usuario = $request->validated('usuario');
        $correo = $request->validated('correo');
        
        $verificarUsuarioCorreo = $this->datosUsuariosAutenticados->verificarUsuarioCorreo($usuario, $correo);
        if (!($verificarUsuarioCorreo)) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Recuperar clave',
                $accion = 3,
                $resultado = 3,
                $descripcion = 'Datos incorrectos, el correo "'.$correo.'" y usuario "'.$usuario.'" no presentan relación alguna.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('error', 'Datos incorrectos, el correo y usuario no presentan relación alguna.');
            return to_route('solicitud-codigo-correo')->onlyInput('usuario', 'correo');
        }

        $enviarCodigo = $this->datosUsuariosAutenticados->enviarCodigoPorUsuarioCorreo($usuario, $correo);
        if ($enviarCodigo) {
            $this->actividades->registrarActividad(
                $usuarioId = null,
                $modulo = 'Recuperar clave',
                $accion = 3,
                $resultado = 1,
                $descripcion = 'Código enviado al correo electrónico "'.$correo.'" exitosamente.',
                $request->ip(),
                $request->header('User-Agent')
            );
            session()->flash('informacion', 'Código enviado a su correo electrónico existosamente.');
            return to_route('nueva-clave');
        }
        $this->actividades->registrarActividad(
            $usuarioId = null,
            $modulo = 'Recuperar clave',
            $accion = 3,
            $resultado = 2,
            $descripcion = 'Error al enviar código al correo electrónico.',
            $request->ip(),
            $request->header('User-Agent')
        );
        session()->flash('advertencia', 'Error, si el problema persiste comuníquese con el administrador de Sistemas.');
        return to_route('solicitud-codigo-correo')->onlyInput('usuario', 'correo');
    }
}
