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
        Schema::create('correos', function (Blueprint $table) {
            $table->id('id_correos'); // Campo de ID autoincremental
            $table->foreignId('cod_empleados')  // Aquí se hace referencia a 'COD_EMPLEADOS' de 'empleados'
                ->references('cod_empleados')  // Especificamos que hace referencia a 'COD_EMPLEADOS' en la tabla 'empleados'
                ->on('empleados')  // Aseguramos que sea la tabla 'empleados'
                ->onDelete('cascade'); // Acción de eliminación en cascada
            $table->string('correo_personal', 100)->notNullable();
            $table->string('correo_profesional', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos');
    }
};
