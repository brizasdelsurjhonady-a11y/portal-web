<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function aplicaciones(): HasMany
    {
        return $this->hasMany(Aplicacion::class);
    }

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }
}
