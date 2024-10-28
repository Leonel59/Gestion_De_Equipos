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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->enum('estado_equipo', ['Activo', 'Inactivo', 'En Mantenimiento'])->default('Activo');
            $table->string('cod_equipo', 10)->unique();
            $table->enum('tipo_equipo', ['Computadora', 'Impresora', 'Otro'])->default('Otro');
            $table->string('numero_serie', 30)->nullable();
            $table->string('marca_equipo', 100)->nullable();
            $table->string('modelo_equipo', 100)->nullable();
            $table->decimal('precio_equipo', 10, 2)->nullable();
            $table->dateTime('fecha_adquisicion')->nullable();
            $table->decimal('depreciacion_equipo', 10, 2)->nullable();
            $table->foreignId('id_usuario')->constrained('users'); // Agregado aquí
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};


