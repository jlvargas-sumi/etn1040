<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Pensum extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'pensum';
    protected $primaryKey = 'pensum_id';
    public $timestamps = false;

}