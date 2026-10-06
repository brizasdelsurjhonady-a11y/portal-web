<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipo_id')
                ->constrained('equipos')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->dateTime('fecha_prestamo');

            $table->dateTime('fecha_devolucion')->nullable();

            $table->string('observacion', 255)->nullable();

            $table->enum('estado', [
                'activo',
                'devuelto',
            ])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
