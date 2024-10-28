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
        Schema::create('producto_mantenimiento', function (Blueprint $table) {
            $table->id('id_producto'); // ID_PRODUCTO como primary key
            $table->unsignedBigInteger('id_proveedor')->nullable(); // ID_PROVEEDOR (sin FK)
            $table->string('nombre_producto', 100); // NOMBRE_PRODUCTO
            $table->string('descripcion_producto', 200); // DESCRIPCION_PRODUCTO
            $table->integer('cantidad_producto')->nullable(); // CANTIDAD_PRODUCTO
            $table->decimal('costo_producto', 10, 2)->nullable(); // COSTO_PRODUCTO
            $table->dateTime('fecha_adquisicion_producto')->nullable(); // FECHA_ADQUISICION_PRODUCTO

            // Constraints
            $table->primary('id_producto');

            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_mantenimiento');
    }
};
