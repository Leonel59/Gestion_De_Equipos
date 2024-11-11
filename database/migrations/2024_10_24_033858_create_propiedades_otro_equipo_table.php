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
        Schema::create('propiedades_otroequipo', function (Blueprint $table) {
            $table->id('id_propiedad_otro'); // Clave primaria ID_PROPIEDAD_OTRO
            $table->unsignedBigInteger('id_equipo'); // Clave foránea ID_EQUIPO
            $table->string('capacidad', 50)->notNullable(); // CAPACIDAD como VARCHAR(50) 
            $table->string('tamano', 50)->notNullable(); // TAMAÑO como VARCHAR(50)
            $table->string('color', 30)->notNullable(); // COLOR como VARCHAR(30)
            $table->timestamps();

            // Definir la clave foránea hacia la tabla equipos
            $table->foreign('id_equipo')->references('id_equipo')->on('equipos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedades_otroequipo');
    }
};