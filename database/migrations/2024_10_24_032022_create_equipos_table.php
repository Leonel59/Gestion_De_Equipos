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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo'); // Clave primaria ID_EQUIPO
            $table->enum('estado_equipo',['Disponible', 'En Mantenimiento','Comodin', 'Asignado' ] ); 
            $table->enum('tipo_equipo', ['Computadora', 'Impresora', 'Otro'])->notNullable(); // TIPO_EQUIPO como ENUM
            $table->string('cod_equipo', 10)->unique(); // COD_EQUIPO con UNIQUE
            $table->string('marca_equipo', 100)->notNullable(); // MARCA_EQUIPO como VARCHAR(100), obligatorio
            $table->string('modelo_equipo', 100)->notNullable(); // MODELO_EQUIPO como VARCHAR(100), obligatorio
            $table->string('numero_serie', 30)->notNullable(); // NUMERO_SERIE como VARCHAR(30), obligatorio
            $table->decimal('precio_equipo', 10, 2)->notNullable(); // PRECIO_EQUIPO como DECIMAL(10,2), obligatorio
            $table->date('fecha_adquisicion')->notNullable(); // FECHA_ADQUISICION como DATE, obligatorio
            $table->decimal('depreciacion_equipo', 10, 2)->notNullable(); // DEPRECIACION_EQUIPO como DECIMAL(10,2), obligatorio
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};


