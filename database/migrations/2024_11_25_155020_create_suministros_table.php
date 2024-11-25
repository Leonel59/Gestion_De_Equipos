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
        Schema::create('suministros', function (Blueprint $table) {
            $table->id('id_suministro'); // Primary key
            $table->unsignedBigInteger('id_proveedor'); // Foreign key to proveedor table
            $table->string('nombre_suministro', 100)->notNullable();
            $table->string('descripcion_suministro', 200)->notNullable();
            $table->date('fecha_adquisicion')->notNullable();
            $table->integer('cantidad_suministro')->default(0)->notNullable();
            $table->decimal('costo_unitario', 10, 2)->notNullable();
            $table->decimal('costo_total', 10, 2)->notNullable();
            $table->timestamps();
            
            // Defining the foreign key constraints
            $table->foreign('id_proveedor')
                  ->references('id_proveedor')->on('proveedor')
                  ->onDelete('cascade'); // Adjust onDelete as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suministros');
    }
};
