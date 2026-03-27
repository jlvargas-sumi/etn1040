<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Docencia extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'docencias';
    protected $primaryKey = 'docencia_id';
    public $timestamps = false;

}