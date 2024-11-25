<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::create('asignacion_suministros', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('id_asignacion'); // id_asignacion INT NOT NULL
            $table->unsignedBigInteger('id_suministro')->nullable(); // id_suministro INT NOT NULL
            $table->timestamps(); // created_at y updated_at

            // Llaves foráneas
            $table->foreign('id_asignacion')
                ->references('id_asignacion')
                ->on('asignaciones')
                ->onDelete('cascade'); // Elimina en cascada los registros relacionados

            $table->foreign('id_suministro')
                ->references('id_suministro')
                ->on('suministros')
                ->onDelete('cascade'); // Elimina en cascada los registros relacionados

            // Restricción única para evitar duplicados
            $table->unique(['id_asignacion', 'id_suministro']);
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_suministros');
    }
};