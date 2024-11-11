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
        Schema::create('propiedades_impresoras', function (Blueprint $table) {
            $table->id('id_propiedad_impr'); // Clave primaria ID_PROPIEDAD_IMPR
            $table->unsignedBigInteger('id_equipo'); // Clave foránea ID_EQUIPO
            $table->string('tipo_impresora', 50)->notNullable(); // TIPO_IMPRESORA como VARCHAR(50)
            $table->string('resolucion_impresora', 30)->notNullable(); // RESOLUCION_IMPRESORA como VARCHAR(30)
            $table->string('conectividad_impresora', 50)->notNullable(); // CONECTIVIDAD_IMPRESORA como VARCHAR(50)
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
        Schema::dropIfExists('propiedades_impresoras');
    }
};