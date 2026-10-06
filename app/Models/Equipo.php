<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'marca',
        'estado',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
