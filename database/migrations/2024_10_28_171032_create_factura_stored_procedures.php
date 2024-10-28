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
                IN p_direccion_empresa VARCHAR(100),
                IN p_cantidad INT,
                IN p_descripcion VARCHAR(200),
                IN p_garantia VARCHAR(15),
                IN p_precio_unitario DECIMAL(10, 2),
                IN p_impuesto DECIMAL(10, 2),
                IN p_total DECIMAL(10, 2)
            )
            BEGIN
                INSERT INTO factura (
                    id_proveedor,
                    tipo_factura,
                    nombre_cliente,
                    rtn_cliente,
                    fecha_facturacion,
                    direccion_empresa,
                    cantidad,
                    descripcion,
                    garantia,
                    precio_unitario,
                    impuesto,
                    total
                ) VALUES (
                    p_id_proveedor,
                    p_tipo_factura,
                    p_nombre_cliente,
                    p_rtn_cliente,
                    p_fecha_facturacion,
                    p_direccion_empresa,
                    p_cantidad,
                    p_descripcion,
                    p_garantia,
                    p_precio_unitario,
                    p_impuesto,
                    p_total
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
