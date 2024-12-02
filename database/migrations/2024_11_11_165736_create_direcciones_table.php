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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id('id_direcciones')->primary();
            $table->foreignId('cod_empleados')  // Aquí se hace referencia a 'COD_EMPLEADOS' de 'empleados'
                ->nullable()  // Permite valores NULL
                ->references('cod_empleados')  // Especificamos que hace referencia a 'COD_EMPLEADOS' en la tabla 'empleados'
                ->on('empleados')  // Aseguramos que sea la tabla 'empleados'
                ->onDelete('cascade'); // Acción de eliminación en cascada
            $table->foreignId('id_proveedor')  // Aquí se hace referencia a 'id_proveedor' de 'proveedor'
                ->nullable()  // Permite valores NULL
                ->references('id_proveedor')  // Especificamos que hace referencia a 'id_proveedor' en la tabla 'proveedor'
                ->on('proveedor')  // Aseguramos que sea la tabla 'proveedor'
                ->onDelete('cascade'); // Acción de eliminación en cascada
            $table->enum('departamento', ['Francisco Morazan', 'Olancho', 'Comayagua', 'El Paraiso', 'Intibuca', 'Lempira', 'Choluteca', 'La Paz']);
            $table->string('ciudad', 100)->notNullable();
            $table->string('direccion', 255)->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
