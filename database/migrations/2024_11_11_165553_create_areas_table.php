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
        Schema::create('areas', function (Blueprint $table) {
            $table->id('id_area', true);
            $table->unsignedBigInteger('id_sucursal')->Notnullable();
            $table->enum('nombre_area', ['Administracion', 'Contabilidad', 'Recursos Humanos', 'Ventas', 'Gerencia IT']);

            $table->unique(['id_sucursal', 'nombre_area'], 'unique_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
