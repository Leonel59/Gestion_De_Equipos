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
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->string('parametro')->unique();
            $table->string('valor');
            $table->unsignedBigInteger('modificado_por')->nullable();
            $table->unsignedBigInteger('creado_por');
            

            $table->foreign('modificado_por')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('creado_por')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};
