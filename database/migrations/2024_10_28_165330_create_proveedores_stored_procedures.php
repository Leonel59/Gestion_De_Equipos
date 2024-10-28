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
        // Crear procedimientos almacenados
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_proveedor;
            DROP PROCEDURE IF EXISTS sp_update_proveedor;
            DROP PROCEDURE IF EXISTS sp_delete_proveedor;

            CREATE PROCEDURE sp_insert_proveedor (
                IN p_nombre_proveedor VARCHAR(100),
                IN p_rtn_proveedor VARCHAR(100),
                IN p_contacto_proveedor VARCHAR(50),
                IN p_direccion_proveedor VARCHAR(150),
                IN p_telefono_proveedor VARCHAR(15),
                IN p_email_proveedor VARCHAR(100)
            )
            BEGIN
                INSERT INTO proveedor (
                    nombre_proveedor,
                    rtn_proveedor,
                    contacto_proveedor,
                    direccion_proveedor,
                    telefono_proveedor,
                    email_proveedor
                ) VALUES (
                    p_nombre_proveedor,
                    p_rtn_proveedor,
                    p_contacto_proveedor,
                    p_direccion_proveedor,
                    p_telefono_proveedor,
                    p_email_proveedor
                );
            END;

            CREATE PROCEDURE sp_update_proveedor (
                IN p_id_proveedor BIGINT,
                IN p_nombre_proveedor VARCHAR(100),
                IN p_rtn_proveedor VARCHAR(100),
                IN p_contacto_proveedor VARCHAR(50),
                IN p_direccion_proveedor VARCHAR(150),
                IN p_telefono_proveedor VARCHAR(15),
                IN p_email_proveedor VARCHAR(100)
            )
            BEGIN
                UPDATE proveedor SET
                    nombre_proveedor = p_nombre_proveedor,
                    rtn_proveedor = p_rtn_proveedor,
                    contacto_proveedor = p_contacto_proveedor,
                    direccion_proveedor = p_direccion_proveedor,
                    telefono_proveedor = p_telefono_proveedor,
                    email_proveedor = p_email_proveedor,
                    updated_at = NOW()
                WHERE id_proveedor = p_id_proveedor;
            END;

            CREATE PROCEDURE sp_delete_proveedor (
                IN p_id_proveedor BIGINT
            )
            BEGIN
                DELETE FROM proveedor WHERE id_proveedor = p_id_proveedor;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar los procedimientos almacenados
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_proveedor;
            DROP PROCEDURE IF EXISTS sp_update_proveedor;
            DROP PROCEDURE IF EXISTS sp_delete_proveedor;
        ');
    }
};
