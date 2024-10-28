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
        Schema::create('propiedades_otro_equipo', function (Blueprint $table) {
            $table->id('id_propiedad_otro'); // Clave primaria autoincremental
            $table->unsignedBigInteger('id_equipo'); // Relación con la tabla equipos
            $table->decimal('capacidad', 10, 2); // Capacidad con dos decimales
            $table->decimal('tamaño', 10, 2)->nullable(); // Tamaño con dos decimales, opcional
            $table->string('color', 30)->nullable(); // Color del equipo, opcional

            $table->timestamps(); // created_at y updated_at

            // Definición de la clave foránea
            $table->foreign('id_equipo')
                ->references('id_equipo')
                ->on('equipos')
                ->onDelete('cascade'); // Eliminar en cascada si se elimina el equipo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedades_otro_equipo');
    }
};
