<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Auxiliar extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'auxiliares';
    protected $primaryKey = 'auxiliar_id';
    public $timestamps = false;

}