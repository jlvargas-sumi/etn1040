<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    public $timestamps = false;

    protected $hidden = [
        'usuario_id',
        'usuario_usuario',
        'usuario_persona_id',
        'usuario_clave',
        // 'remember_token',
    ];//inecesario
    protected $fillable = [
        'usuario_usuario',
        'usuario_clave',
    ];
    public function getAuthPassword()
    {
        return $this->usuario_clave;
    }
}