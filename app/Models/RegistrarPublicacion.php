<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegistrarPublicacion extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'registrar_publicaciones';
    protected $primaryKey = 'registrar_publ_id';
    public $timestamps = false;

    private $comunicado = 'Comunicado';
    private $convocatoria = 'Convocatoria';
    private $disk = "public";

    
}
