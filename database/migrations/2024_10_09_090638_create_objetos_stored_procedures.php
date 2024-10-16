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
            DROP PROCEDURE IF EXISTS sp_insert_objeto;
            DROP PROCEDURE IF EXISTS sp_update_objeto;
            DROP PROCEDURE IF EXISTS sp_delete_objeto;

            CREATE PROCEDURE sp_insert_objeto (
                IN p_objeto VARCHAR(255),
                IN p_descripcion TEXT,
                IN p_creado_por BIGINT
            )
            BEGIN
                INSERT INTO objetos (
                    objeto,
                    descripcion,
                    creado_por
                ) VALUES (
                    p_objeto,
                    p_descripcion,
                    p_creado_por
                );
            END;

            CREATE PROCEDURE sp_update_objeto (
                IN p_id BIGINT,
                IN p_objeto VARCHAR(255),
                IN p_descripcion TEXT,
                IN p_modificado_por BIGINT
            )
            BEGIN
                UPDATE objetos SET
                    objeto = p_objeto,
                    descripcion = p_descripcion,
                    modificado_por = p_modificado_por,
                    updated_at = NOW()
                WHERE id = p_id;
            END;

            CREATE PROCEDURE sp_delete_objeto (
                IN p_id BIGINT
            )
            BEGIN
                DELETE FROM objetos WHERE id = p_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_objeto;
            DROP PROCEDURE IF EXISTS sp_update_objeto;
            DROP PROCEDURE IF EXISTS sp_delete_objeto;
        ');
    }
};
