<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('id_proveedor'); // ID auto incremental y clave primaria
            $table->string('nombre_proveedor', 100); // Nombre del proveedor
            $table->string('rtn_proveedor', 100)->unique(); // RTN del proveedor, único
            $table->string('contacto_proveedor', 50)->nullable(); // Contacto del proveedor
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
