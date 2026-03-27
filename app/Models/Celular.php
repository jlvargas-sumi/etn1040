<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Celular extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'celulares';
    protected $primaryKey = 'celular_id';
    public $timestamps = false;

}