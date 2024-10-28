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
        Schema::create('propiedades_computadoras', function (Blueprint $table) {
            $table->id('id_propiedad_comp'); // Clave primaria autoincremental
            $table->unsignedBigInteger('id_equipo'); // Relación con la tabla equipos
            $table->string('procesador_comp', 50); // Procesador de la computadora
            $table->string('memoria_comp', 20); // Memoria de la computadora
            $table->string('tipodisco_comp', 50); // Tipo de disco
            $table->string('sistema_operativo_comp', 100); // Sistema operativo

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
        Schema::dropIfExists('propiedades_computadoras');
    }
};
