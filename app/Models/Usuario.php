<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    public $timestamps = false;

    protected $rememberTokenName = null;

    protected $fillable = ['username', 'password'];

    // Nunca devolver la contraseña en JSON
    protected $hidden = ['password'];
}