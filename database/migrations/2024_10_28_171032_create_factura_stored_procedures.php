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
            DROP PROCEDURE IF EXISTS sp_insert_factura;
            DROP PROCEDURE IF EXISTS sp_delete_factura;

            CREATE PROCEDURE sp_insert_factura (
                IN p_id_proveedor BIGINT,
                IN p_tipo_factura VARCHAR(100),
                IN p_nombre_cliente VARCHAR(100),
                IN p_rtn_cliente VARCHAR(20),
                IN p_fecha_facturacion DATETIME,
                IN p_imagen VARCHAR(255)  -- Nuevo parámetro para la imagen
            )
            BEGIN
                INSERT INTO factura (
                    id_proveedor,
                    tipo_factura,
                    nombre_cliente,
                    rtn_cliente,
                    fecha_facturacion,
                    imagen  -- Nuevo campo para la imagen
                ) VALUES (
                    p_id_proveedor,
                    p_tipo_factura,
                    p_nombre_cliente,
                    p_rtn_cliente,
                    p_fecha_facturacion,
                    p_imagen  -- Valor de la imagen
                );
            END;

            CREATE PROCEDURE sp_delete_factura (
                IN p_cod_factura BIGINT
            )
            BEGIN
                DELETE FROM factura WHERE cod_factura = p_cod_factura;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_factura;
            DROP PROCEDURE IF EXISTS sp_delete_factura;
        ');
    }
};
