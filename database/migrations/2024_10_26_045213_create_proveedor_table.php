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
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('id_proveedor'); // ID del proveedor
            $table->string('nombre_proveedor', 100); // Nombre del proveedor
            $table->string('rtn_proveedor', 100)->unique(); // RTN del proveedor, único
            $table->string('contacto_proveedor', 50)->nullable(); // Contacto del proveedor, opcional
            $table->string('direccion_proveedor', 150)->nullable(); // Dirección del proveedor, opcional
            $table->string('telefono_proveedor', 15)->nullable(); // Teléfono del proveedor, opcional
            $table->string('email_proveedor', 100)->nullable(); // Email del proveedor, opcional
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
