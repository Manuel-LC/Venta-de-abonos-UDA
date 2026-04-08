<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = ['username', 'password'];

    // Nunca devolver la contraseña en JSON
    protected $hidden = ['password'];
}
