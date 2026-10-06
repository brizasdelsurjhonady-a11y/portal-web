<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->cascadeOnDelete();

            $table->string('codigo', 30)->unique();

            $table->string('nombre');

            $table->string('marca')->nullable();

            $table->enum('estado', [
                'disponible',
                'prestado',
                'mantenimiento',
                'baja',
            ])->default('disponible');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
