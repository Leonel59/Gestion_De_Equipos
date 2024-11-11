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
            $table->id('id_propiedad_comp'); // Clave primaria ID_PROPIEDAD_COMP
            $table->unsignedBigInteger('id_equipo'); // Clave foránea ID_EQUIPO
            $table->string('serie_cargador_comp', 50)->nullable(); // SERIE_CARGADOR_COMP como VARCHAR(50)
            $table->string('procesador_comp', 50)->notNullable(); // PROCESADOR_COMP como VARCHAR(50)
            $table->string('memoria_comp', 20)->notNullable(); // MEMORIA_COMP como VARCHAR(20)
            $table->string('tarjeta_grafica_comp', 50)->nullable();// TARJETA_GRAFICA_COMP como VARCHAR(50)
            $table->string('tipodisco_comp', 50)->notNullable(); // TIPODISCO_COMP como VARCHAR(50)
            $table->string('sistema_operativo_comp', 100)->notNullable(); // SISTEMA_OPERATIVO_COMP como VARCHAR(100)
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
        Schema::dropIfExists('propiedades_computadoras');
    }
};