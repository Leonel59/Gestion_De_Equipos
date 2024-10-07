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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pregunta');
            $table->unsignedBigInteger('id_usuario');
            $table->string('respuesta');
            $table->primary(['id_pregunta','id_usuario']);

            $table->foreign('id_pregunta')->references('id')
            ->on('preguntas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
