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
            $table->id('id_asignacion'); // Primary key
            $table->unsignedBigInteger('id_equipo'); // Foreign key to equipos table
            $table->unsignedBigInteger('id_sucursal'); // Clave foránea a la tabla `sucursales`
            $table->unsignedBigInteger('id_area')->nullable(); // Clave foránea a la tabla `areas`
            $table->unsignedBigInteger('cod_empleados')->nullable();
            $table->unsignedBigInteger('id_suministro')->nullable();
            $table->string('detalle_asignacion', 100)->notNullable();
            $table->date('fecha_asignacion')->notNullable();
            $table->date('fecha_devolucion')->notNullable();
            $table->timestamps();


            // Definir las restricciones de clave foránea
            $table->foreign('id_equipo')->references('id_equipo')->on('equipos')
                ->onDelete('cascade'); // Adjust onDelete as needed
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursales')
                ->onDelete('cascade'); // Acción de eliminación en cascada
            $table->foreign('id_area')->references('id_area')->on('areas')
                ->onDelete('cascade'); // Acción de eliminación en cascada
            $table->foreign('cod_empleados')->references('cod_empleados')->on('empleados')
                ->onDelete('cascade'); // Acción de eliminación en cascada
                $table->foreign('id_suministro')->references('id_suministro')->on('suministros')
                ->onDelete('cascade'); // Acción de eliminación en cascada

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
