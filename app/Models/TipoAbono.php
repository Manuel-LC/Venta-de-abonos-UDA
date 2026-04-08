<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoAbono extends Model
{
    protected $table      = 'tipo_abonos';
    protected $primaryKey = 'id';
    public    $keyType    = 'string';
    public    $incrementing = false;
    public    $timestamps = false;

    protected $fillable = ['id', 'descripcion', 'precio'];

    public function abonos(): HasMany
    {
        return $this->hasMany(Abono::class, 'tipo');
    }
}