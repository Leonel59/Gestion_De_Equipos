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
        // Verifica si la tabla 'objetos' ya existe
        if (!Schema::hasTable('objetos')) {
            Schema::create('objetos', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Nombre del módulo/objeto (e.g., equipos, usuarios, etc.)
                $table->timestamps();
            });
        }

        // Verifica si la tabla 'objetos_roles_permisos' ya existe
        if (!Schema::hasTable('objetos_roles_permisos')) {
            Schema::create('objetos_roles_permisos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('objeto_id')->constrained('objetos')->onDelete('cascade'); // Relación con la tabla objetos
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Relación con la tabla roles

                // Permisos por sección/módulo
                $table->boolean('ver')->default(false);
                $table->boolean('insertar')->default(false);
                $table->boolean('editar')->default(false);
                $table->boolean('eliminar')->default(false);

                $table->timestamps();

                // Clave única para evitar duplicados
                $table->unique(['objeto_id', 'role_id'], 'objeto_role_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Asegúrate de eliminar las tablas en el reverse de la migración
        Schema::dropIfExists('objetos_roles_permisos');
        Schema::dropIfExists('objetos');
    }
};
