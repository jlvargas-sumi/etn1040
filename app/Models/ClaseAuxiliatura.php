<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ClaseAuxiliatura extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'clases_auxiliaturas';
    protected $primaryKey = 'clase_auxiliatura_id';
    public $timestamps = false;

}