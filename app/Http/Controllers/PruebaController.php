<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\DatoAcademicoCarrera;
use App\Models\DatoUsuarioAutenticado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

use Dompdf\Dompdf;
use Dompdf\Options;


class PruebaController extends Controller
{
    private $datosAcademicosCarrera;
    private $datosUsuariosAutenticados;

    public function __construct()
    {
        $this->datosAcademicosCarrera = new DatoAcademicoCarrera;
        $this->datosUsuariosAutenticados = new DatoUsuarioAutenticado;
    }

    public function indice()
    {

        $rolInicialUsuarioPorUsuarioId = $this->datosUsuariosAutenticados->rolInicialUsuarioPorUsuarioId(10);
        $datos = ['codigo_usuario_id' => 1, 'codigo_fecha' => date('Y-m-d H:i:s'), 'codigo_estado' => 1];
        $codigo = DB::table('codigos')->insertGetId($datos);//Procesar envio de $codigo por correos a $correo
        $datos = DB::table('test')->get();
        return view('pruebas', ['datos' => $datos]);
        // $mencionesId = DB::table('menciones')->select('mencion_id')
        //     ->distinct()
        //     ->join('pensum', 'mencion_id', '=', 'pensum_mencion_id')
        //     ->join('asignaturas', 'pensum_asignatura_id', '=', 'asignatura_id')
        //     ->join('plan_estudios', 'asignatura_plan_estudio_id', '=', 'plan_estudio_id')
        //     ->where('plan_estudio_id', 4)
        //     ->orderBy('mencion_id')
        //     ->get();
        // return $mencionesId;
    }
    public function rich(Request $request)
    {
        // dump($request);
        $cadena = $request->input('nombre');
        $texto = $request->input('descripcion');
        $datos = [
            'test_cadena'=>$cadena,
            'test_texto'=>$texto,
        ];
        DB::table('test')->insert($datos);
        return to_route('pruebas');

    }
    public function pdf()
    {
        ini_set('memory_limit', '2048M');//Allowed memory size of xxx bytes exhausted
        
        $options = new Options();
        $dompdf = new Dompdf($options);
        $options->set('chroot', __DIR__);
        $options->set('isPhpEnabled', true);
        
        $datos = DB::table('test')->where('test_id', 3)->get();
        $datos = $datos[0];
        
        
        $vista =  View::make('pruebas-pdf', compact(
            'datos'
        ))->render();
        // return $vista;
        $pdf = PDF::loadHtml($vista, 'UTF-8')->setPaper('A4')->setWarnings(false);

        return $pdf->stream('testPDF.pdf', ['Attachment' => false]);
    }
    public function bcsrf(Request $request)
    {
        return 1;
    }
    public function buscar(Request $request)
    {
        return $request;
    }
    public function borrarCache(){
        $exitCode = Artisan::call('cache:clear');
        $exitCode += Artisan::call('config:clear');
        $exitCode += Artisan::call('route:clear');
        $exitCode += Artisan::call('view:clear');

        if ($exitCode === 0) {
            session()->flash('exito', 'Cache borrada exitosamente');
            return to_route('pruebas');
        }
        session()->flash('error', 'Error, no se pudo Borrar Cache, intente nuevamente.');
        return to_route('pruebas');
    }
}
