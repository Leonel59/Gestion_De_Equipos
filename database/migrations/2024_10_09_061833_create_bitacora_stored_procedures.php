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
            DROP PROCEDURE IF EXISTS sp_insert_bitacora;
            DROP PROCEDURE IF EXISTS sp_get_all_bitacora;
            DROP PROCEDURE IF EXISTS sp_delete_bitacora;

            CREATE PROCEDURE sp_insert_bitacora (
                IN p_fecha DATETIME,
                IN p_id_usuario BIGINT,
                IN p_tabla VARCHAR(50),
                IN p_accion VARCHAR(50),
                IN p_descripcion VARCHAR(200),
                IN p_valores_anteriores TEXT,
                IN p_valores_nuevos TEXT
            )
            BEGIN
                INSERT INTO bitacoras (
                    fecha,
                    id_usuario,
                    tabla,
                    accion,
                    descripcion,
                    valores_anteriores,
                    valores_nuevos
                ) VALUES (
                    p_fecha,
                    p_id_usuario,
                    p_tabla,
                    p_accion,
                    p_descripcion,
                    p_valores_anteriores,
                    p_valores_nuevos
                );
            END;

            CREATE PROCEDURE sp_get_all_bitacora ()
            BEGIN
                SELECT * FROM bitacoras;
            END;

            CREATE PROCEDURE sp_delete_bitacora (
                IN p_id BIGINT
            )
            BEGIN
                DELETE FROM bitacoras WHERE id = p_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_bitacora;
            DROP PROCEDURE IF EXISTS sp_get_all_bitacora;
            DROP PROCEDURE IF EXISTS sp_delete_bitacora;
        ');
    }
};
