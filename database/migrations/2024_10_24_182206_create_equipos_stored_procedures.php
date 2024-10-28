<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_create_equipo;
            DROP PROCEDURE IF EXISTS sp_update_equipo;
            DROP PROCEDURE IF EXISTS sp_delete_equipo;

            CREATE PROCEDURE sp_create_equipo (
                IN p_cod_equipo VARCHAR(10),
                IN p_estado_equipo ENUM("Activo", "Inactivo", "En Mantenimiento"), -- Cambiado a ENUM
                IN p_tipo_equipo ENUM("Computadora", "Impresora", "Otro"),        -- Cambiado a ENUM
                IN p_numero_serie VARCHAR(255),
                IN p_marca_equipo VARCHAR(255),
                IN p_modelo_equipo VARCHAR(255),
                IN p_precio_equipo DECIMAL(10, 2),
                IN p_fecha_adquisicion DATE,
                IN p_depreciacion_equipo DECIMAL(10, 2),
                IN p_id_usuario BIGINT
            )
            BEGIN
                INSERT INTO equipos (
                    cod_equipo,
                    estado_equipo,
                    tipo_equipo,
                    numero_serie,
                    marca_equipo,
                    modelo_equipo,
                    precio_equipo,
                    fecha_adquisicion,
                    depreciacion_equipo,
                    id_usuario
                ) VALUES (
                    p_cod_equipo,
                    p_estado_equipo,
                    p_tipo_equipo,
                    p_numero_serie,
                    p_marca_equipo,
                    p_modelo_equipo,
                    p_precio_equipo,
                    p_fecha_adquisicion,
                    p_depreciacion_equipo,
                    p_id_usuario
                );
            END;

            CREATE PROCEDURE sp_update_equipo (
                IN p_cod_equipo VARCHAR(10),
                IN p_nuevo_cod_equipo VARCHAR(10),
                IN p_estado_equipo ENUM("Activo", "Inactivo", "En Mantenimiento"), -- Cambiado a ENUM
                IN p_tipo_equipo ENUM("Computadora", "Impresora", "Otro"),        -- Cambiado a ENUM
                IN p_numero_serie VARCHAR(255),
                IN p_marca_equipo VARCHAR(255),
                IN p_modelo_equipo VARCHAR(255),
                IN p_precio_equipo DECIMAL(10, 2),
                IN p_fecha_adquisicion DATE,
                IN p_depreciacion_equipo DECIMAL(10, 2)
            )
            BEGIN
                UPDATE equipos SET
                    cod_equipo = p_nuevo_cod_equipo,
                    estado_equipo = p_estado_equipo,
                    tipo_equipo = p_tipo_equipo,
                    numero_serie = p_numero_serie,
                    marca_equipo = p_marca_equipo,
                    modelo_equipo = p_modelo_equipo,
                    precio_equipo = p_precio_equipo,
                    fecha_adquisicion = p_fecha_adquisicion,
                    depreciacion_equipo = p_depreciacion_equipo
                WHERE cod_equipo = p_cod_equipo;
            END;

            CREATE PROCEDURE sp_delete_equipo (
                IN p_cod_equipo VARCHAR(10) -- Usando el cod_equipo como parámetro
            )
            BEGIN
                DELETE FROM equipos WHERE cod_equipo = p_cod_equipo; -- Eliminando por cod_equipo
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_create_equipo;
            DROP PROCEDURE IF EXISTS sp_update_equipo;
            DROP PROCEDURE IF EXISTS sp_delete_equipo;
        ');
    }
};
