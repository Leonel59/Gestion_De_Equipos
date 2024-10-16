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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->unsignedBigInteger('id_usuario');
            $table->string('tabla');
            $table->string('accion');
            $table->string('descripcion');
            
            $table->text('valores_anteriores')->nullable(); // Campo para valores anteriores
            $table->text('valores_nuevos')->nullable();     // Campo para valores nuevos
        
            // Columnas de marca de tiempo
            $table->timestamps();
        
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
