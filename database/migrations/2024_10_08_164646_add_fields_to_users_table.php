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
        Schema::table('users', function (Blueprint $table) {
            // Verificar y añadir la columna 'role' si no existe
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['user', 'admin'])->default('user');
            }

            // Verificar y añadir la columna 'security_question' si no existe
            if (!Schema::hasColumn('users', 'security_question')) {
                $table->string('security_question')->nullable();
            }

            // Verificar y añadir la columna 'security_answer' si no existe
            if (!Schema::hasColumn('users', 'security_answer')) {
                $table->string('security_answer')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar las columnas en caso de revertir
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'security_question')) {
                $table->dropColumn('security_question');
            }

            if (Schema::hasColumn('users', 'security_answer')) {
                $table->dropColumn('security_answer');
            }
        });
    }
};
