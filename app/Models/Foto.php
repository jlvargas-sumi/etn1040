<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'fotos';
    protected $primaryKey = 'foto_id';
    
    public $timestamps = false;

    protected $fillable = [
        'foto_persona_id',
        'foto_archivo'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'foto_persona_id', 'persona_id');
    }
}