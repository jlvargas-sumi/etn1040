<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Apertura extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'aperturas';
    protected $primaryKey = 'apertura_id';
    public $timestamps = false;

}