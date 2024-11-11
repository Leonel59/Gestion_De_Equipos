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
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id('id_asignacion'); // Clave primaria con auto_increment
            $table->unsignedBigInteger('cod_empleados'); // Relación con la tabla empleados
            $table->string('sucursal'); // Campo para la sucursal
            $table->string('detalle_asignacion', 100); // Campo con detalles de la asignación
            $table->dateTime('fecha_asignacion')->nullable(); // Fecha de asignación
            $table->dateTime('fecha_devolucion')->nullable(); // Fecha de devolución
            $table->timestamps(); // created_at y updated_at

            // Definición de claves foráneas
            $table->foreign('cod_empleados') // No es necesario definir de nuevo la columna
                ->references('cod_empleados')
                ->on('empleados')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};

