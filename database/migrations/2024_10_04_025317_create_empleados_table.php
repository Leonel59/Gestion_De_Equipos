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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('cod_empleado')->unique();
            $table->string('correo')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('sucursal')->nullable();
            $table->string('area')->nullable();
            $table->string('dni_empleado')->unique();
            $table->string('nombre_empleado');
            $table->string('apellido_empleado');
            $table->string('cargo_empleado');
            $table->date('fecha_contratacion');
            $table->enum('sexo_empleado', ['masculino', 'femenino', 'otro']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
