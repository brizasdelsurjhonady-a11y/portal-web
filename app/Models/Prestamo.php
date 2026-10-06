<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestamo extends Model
{
    protected $fillable = [
        'equipo_id',
        'user_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'observacion',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_prestamo' => 'datetime',
            'fecha_devolucion' => 'datetime',
        ];
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
