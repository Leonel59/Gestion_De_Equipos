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
            $table->id('id_propiedad_impr'); // Clave primaria autoincremental
            $table->unsignedBigInteger('id_equipo'); // Relación con la tabla equipos
            $table->string('tipo_impresora', 50); // Tipo de impresora
            $table->string('resolucion_impresora', 30)->nullable(); // Resolución de la impresora, opcional
            $table->string('conectividad_impresora', 50)->nullable(); // Conectividad de la impresora, opcional

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
        Schema::dropIfExists('propiedades_impresoras');
    }
};
