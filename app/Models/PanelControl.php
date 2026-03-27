<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelControl extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'panel_control';
    protected $primaryKey = 'panel_control_id';
    public $timestamps = false;
    
    public function panelControl()
    {
        $panelControl = PanelControl::join('periodos', 'panel_control_periodo_id', '=', 'periodo_id')
            ->join('plan_estudios', 'panel_control_plan_estudio_id', '=', 'plan_estudio_id')
            ->orderBy('panel_control_id', 'desc')->get();
        return $panelControl;
    }
    public function panelControlActual()
    {
        $panelControl = PanelControl::join('periodos', 'panel_control_periodo_id', '=', 'periodo_id')
            ->join('plan_estudios', 'panel_control_plan_estudio_id', '=', 'plan_estudio_id')
            ->where('panel_control_estado', 1)->first();
        return $panelControl;
    }
    public function habilitarApertura($request)
    {
        $id = $request->input('id');
        $planEstudioId = $request->input('plan_estudio_id');

        
        DB::beginTransaction();
        try {
            $periodoId = PanelControl::select('panel_control_periodo_id')->where('panel_control_id', $id)->value('panel_control_periodo_id');
            
            $asignaturas = Asignatura::where('asignatura_plan_estudio_id', $planEstudioId)->get();
            foreach ($asignaturas as $i => $asignatura) {
                $datos = [
                    'apertura_periodo_id' => $periodoId,
                    'apertura_asignatura_id' => $asignatura->asignatura_id,
                    'apertura_campo' => "Teoría",
                    'apertura_extraordinario' => null,
                    'apertura_paralelo' => "A",
                    'apertura_inscripcion' => 0,
                    'apertura_estado' => 1
                ];
                Apertura::create($datos);

                if ($asignatura->asignatura_laboratorio === 1) {
                    $datos = [
                        'apertura_periodo_id' => $periodoId,
                        'apertura_asignatura_id' => $asignatura->asignatura_id,
                        'apertura_campo' => "Laboratorio",
                        'apertura_extraordinario' => null,
                        'apertura_paralelo' => "A",
                        'apertura_inscripcion' => null,
                        'apertura_estado' => 1
                    ];
                    Apertura::create($datos);
                }
            }

            $datos = [
                'panel_control_plan_estudio_id' => $planEstudioId,
                'panel_control_apertura' => 1
            ];
            PanelControl::where('panel_control_id', $id)->update($datos);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function habilitarInscripcion($id)
    {
        try {
            $datos = [
                'panel_control_inscripcion' => 1
            ];
            PanelControl::where('panel_control_id', $id)->update($datos);

            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function deshabilitarInscripcion($id)
    {
        try {
            $datos = [
                'panel_control_inscripcion' => 0
            ];
            PanelControl::where('panel_control_id', $id)->update($datos);

            return true;
        }
        catch (\Throwable $th) {
            return false;
        }
    }
    public function habilitarPeriodo($id)
    {
        DB::beginTransaction();
        try {
            DB::table('panel_control')->update(['panel_control_estado' => 0]);
            PanelControl::where('panel_control_id', $id)->update(['panel_control_estado'=> 1]);

            DB::commit();
            return true;
        } 
        catch (\Throwable $th) {
            DB::rollback();
            return false; 
        }
    }
    public function estadoInscripcionPorPeriodoGestion($periodo, $gestion)
    {
        $estado = PanelControl::select('panel_control_inscripcion')
            ->join('periodos', 'panel_control_periodo_id', '=', 'periodo_id')
            ->where('periodo_nombre', $periodo)
            ->where('periodo_gestion', $gestion)
            ->value('panel_control_inscripcion');
            
        return $estado;
    }

}