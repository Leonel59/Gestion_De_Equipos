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
        Schema::create('asignacion_equipo', function (Blueprint $table) {
            $table->id('id_asig_equipo'); // Clave primaria autoincremental
            $table->unsignedBigInteger('id_equipo'); // Relación con la tabla equipos
            $table->unsignedBigInteger('id_asignacion'); // Relación con la tabla asignaciones
            $table->timestamps();

            // Definición de las claves foráneas
            $table->foreign('id_equipo')
                ->references('id_equipo')
                ->on('equipos')
                ->onDelete('cascade');

            $table->foreign('id_asignacion')
                ->references('id_asignacion')
                ->on('asignaciones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_equipo');
    }
};
