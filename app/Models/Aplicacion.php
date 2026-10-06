<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aplicacion extends Model
{
    protected $table = 'aplicaciones';

    protected $fillable = [
        'categoria_id',
        'user_id',
        'nombre',
        'descripcion',
        'url',
        'logo',
        'estado',
        'motivo_rechazo',
        'destacada',
        'visitas',
    ];

    protected function casts(): array
    {
        return [
            'destacada' => 'boolean',
            'visitas' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON CATEGORÍA
    |--------------------------------------------------------------------------
    */

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON USUARIO / ESTUDIANTE
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
