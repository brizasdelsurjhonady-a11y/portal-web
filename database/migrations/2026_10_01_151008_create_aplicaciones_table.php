<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aplicaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->string('url');
            $table->string('logo')->nullable();

            $table->enum('estado', [
                'pendiente',
                'publicada',
                'rechazada'
            ])->default('pendiente');

            $table->string('motivo_rechazo')->nullable();
            $table->boolean('destacada')->default(false);
            $table->unsignedInteger('visitas')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplicaciones');
    }
};
