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
            $table->string('cod_empleados'); // Relación con la tabla empleados
            $table->string('sucursal'); // Campo para la sucursal
            $table->string('detalle_asignacion', 100); // Campo con detalles de la asignación
            $table->dateTime('fecha_asignacion')->nullable(); // Fecha de asignación
            $table->dateTime('fecha_devolucion')->nullable(); // Fecha de devolución
            $table->timestamps(); // created_at y updated_at

            // Definición de claves foráneas
            $table->foreign('cod_empleados')
                ->references('cod_empleado')
                ->on('empleados')
                ->onDelete('cascade');

            // Si sucursal es una clave foránea, descomentar y modificar la siguiente línea
            // $table->foreign('sucursal')
            //     ->references('id_sucursal') // Cambia esto según la clave primaria de la tabla de sucursales
            //     ->on('sucursales') // Cambia esto según el nombre de tu tabla de sucursales
            //     ->onDelete('cascade');
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

