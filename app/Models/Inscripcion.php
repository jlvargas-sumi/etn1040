<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Inscripcion extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'inscripciones';
    protected $primaryKey = 'inscripcion_id';

    public $timestamps = false;

}