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
        Schema::create('servicios_mantenimientos', function (Blueprint $table) {
            $table->id('id_mant'); // ID_MANT como primary key
            $table->string('id_equipo_mant', 10);
            $table->enum('tipo_mantenimiento', ['Preventivo', 'Correctivo', 'Predictivo']); // TIPO_MANTENIMIENTO
            $table->string('descripcion_mantenimiento', 200); // DESCRIPCION_MANTENIMIENTO
            $table->integer('cantidad_equipo_usado')->nullable(); // CANTIDAD_EQUIPO_USADO
            $table->dateTime('fecha_reparacion_equipo')->nullable(); // FECHA_REPARACION_EQUIPO
            $table->dateTime('fecha_entrega_equipo')->nullable(); // FECHA_ENTREGA_EQUIPO
            $table->decimal('costo_mantenimiento', 10, 2)->nullable(); // COSTO_MANTENIMIENTO
            $table->integer('duracion_mantenimiento')->nullable(); // DURACION_MANTENIMIENTO
            $table->dateTime('fecha_creacion'); // FECHA_CREACION
            $table->string('modificado_por', 100)->nullable(); // MODIFICADO_POR
            $table->dateTime('fecha_modificacion')->nullable(); // FECHA_MODIFICACION
            
            // Constraints
           // En la migración de la tabla `servicios_mantenimientos`

$table->foreign('id_equipo_mant')->references('cod_equipo')->on('equipos')->onDelete('cascade');


            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_mantenimientos');
    }
};
