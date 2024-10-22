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
            DROP PROCEDURE IF EXISTS sp_insert_parametro;
            DROP PROCEDURE IF EXISTS sp_update_parametro;
            DROP PROCEDURE IF EXISTS sp_delete_parametro;

            CREATE PROCEDURE sp_insert_parametro (
                IN p_parametro VARCHAR(255),
                IN p_valor VARCHAR(255),
                IN p_creado_por BIGINT
            )
            BEGIN
                INSERT INTO parametros (
                    parametro,
                    valor,
                    creado_por
                ) VALUES (
                    p_parametro,
                    p_valor,
                    p_creado_por
                );
            END;

            CREATE PROCEDURE sp_update_parametro (
                IN p_id BIGINT,
                IN p_parametro VARCHAR(255),
                IN p_valor VARCHAR(255),
                IN p_modificado_por BIGINT
            )
            BEGIN
                UPDATE parametros SET
                    parametro = p_parametro,
                    valor = p_valor,
                    modificado_por = p_modificado_por,
                    updated_at = NOW()
                WHERE id = p_id;
            END;

            CREATE PROCEDURE sp_delete_parametro (
                IN p_id BIGINT
            )
            BEGIN
                DELETE FROM parametros WHERE id = p_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_parametro;
            DROP PROCEDURE IF EXISTS sp_update_parametro;
            DROP PROCEDURE IF EXISTS sp_delete_parametro;
        ');
    }
};


