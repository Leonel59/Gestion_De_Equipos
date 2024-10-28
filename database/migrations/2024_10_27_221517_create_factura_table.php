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
        Schema::create('factura', function (Blueprint $table) {
            $table->id('cod_factura'); // Código de la factura (primary key)
            $table->unsignedBigInteger('id_proveedor'); // ID del proveedor (foreign key)
            $table->string('tipo_factura', 100); // Tipo de factura (sin referencia a otra tabla)
            $table->string('nombre_cliente', 100); // Nombre del cliente
            $table->string('rtn_cliente', 20)->unique(); // RTN del cliente, único
            $table->dateTime('fecha_facturacion'); // Fecha de facturación
            $table->string('direccion_empresa', 100)->nullable(); // Dirección de la empresa
            $table->integer('cantidad'); // Cantidad de productos o servicios
            $table->string('descripcion', 200); // Descripción de la factura
            $table->string('garantia', 15)->nullable(); // Garantía (opcional)
            $table->decimal('precio_unitario', 10, 2); // Precio unitario
            $table->decimal('impuesto', 10, 2); // Impuesto aplicado
            $table->decimal('total', 10, 2); // Total de la factura

            // Llave foránea con la tabla proveedor
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor')->onDelete('cascade');

            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura');
    }
};
