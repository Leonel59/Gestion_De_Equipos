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
            $table->id('cod_empleados')->primary();
            $table->unsignedInteger('id_sucursal')->nullable()->index('fk_empleados_sucursal_id_sucursal');
            $table->unsignedInteger('id_area')->nullable()->index('fk_empleados_area_id_area');
            $table->string('nombre_empleado', 100);
            $table->string('apellido_empleado', 100);
            $table->string('cargo_empleado', 30);
            $table->enum('estado_empleado', ['Activo', 'Inactivo', 'Asignado']);
            $table->date('fecha_contratacion');
            $table->dateTime('fecha_modificacion')->nullable();
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
