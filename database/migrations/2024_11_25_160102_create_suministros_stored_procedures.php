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
            DROP PROCEDURE IF EXISTS sp_insert_suministro;
            DROP PROCEDURE IF EXISTS sp_update_suministro;
            DROP PROCEDURE IF EXISTS sp_delete_suministro;

            CREATE PROCEDURE sp_insert_suministro(
                IN p_id_proveedor INT,
                IN p_nombre_suministro VARCHAR(100),
                IN p_descripcion_suministro VARCHAR(200),
                IN p_fecha_adquisicion DATE,
                IN p_cantidad_suministro INT,
                IN p_costo_unitario DECIMAL(10, 2)
            )
            BEGIN
                -- Verificar si el proveedor existe
                IF NOT EXISTS (SELECT 1 FROM proveedor WHERE id_proveedor = p_id_proveedor) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: El proveedor no existe.";
                END IF;

                -- Validar que la fecha de adquisición no sea futura
                IF p_fecha_adquisicion > CURDATE() THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La fecha de adquisición no puede ser futura.";
                END IF;

                -- Calcular costo_total y hacer la inserción
                INSERT INTO suministros (
                    id_proveedor,
                    nombre_suministro,
                    descripcion_suministro,
                    fecha_adquisicion,
                    cantidad_suministro,
                    costo_unitario,
                    costo_total
                ) VALUES (
                    p_id_proveedor,
                    p_nombre_suministro,
                    p_descripcion_suministro,
                    p_fecha_adquisicion,
                    p_cantidad_suministro,
                    p_costo_unitario,
                    p_cantidad_suministro * p_costo_unitario
                );
            END;

            CREATE PROCEDURE sp_update_suministro(
                IN p_id_suministro INT,
                IN p_id_proveedor INT,
                IN p_nombre_suministro VARCHAR(100),
                IN p_descripcion_suministro VARCHAR(200),
                IN p_fecha_adquisicion DATE,
                IN p_cantidad_suministro INT,
                IN p_costo_unitario DECIMAL(10, 2)
            )
            BEGIN
                -- Verificar si el suministro existe
                IF NOT EXISTS (SELECT 1 FROM suministros WHERE id_suministro = p_id_suministro) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: El suministro no existe.";
                END IF;

                -- Verificar si el proveedor existe
                IF NOT EXISTS (SELECT 1 FROM proveedor WHERE id_proveedor = p_id_proveedor) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: El proveedor no existe.";
                END IF;

                -- Validar que la fecha de adquisición no sea futura
                IF p_fecha_adquisicion > CURDATE() THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La fecha de adquisición no puede ser futura.";
                END IF;

                -- Calcular costo_total y hacer la actualización
                UPDATE suministros 
                SET 
                    id_proveedor = p_id_proveedor,
                    nombre_suministro = p_nombre_suministro,
                    descripcion_suministro = p_descripcion_suministro,
                    fecha_adquisicion = p_fecha_adquisicion,
                    cantidad_suministro = p_cantidad_suministro,
                    costo_unitario = p_costo_unitario,
                    costo_total = p_cantidad_suministro * p_costo_unitario
                WHERE id_suministro = p_id_suministro;
            END;

            CREATE PROCEDURE sp_delete_suministro (
                IN p_id_suministro INT
            )
            BEGIN
                -- Verificar si el suministro existe
                IF NOT EXISTS (SELECT 1 FROM suministros WHERE id_suministro = p_id_suministro) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: El suministro no existe.";
                END IF;

                -- Eliminar el suministro
                DELETE FROM suministros WHERE id_suministro = p_id_suministro;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_suministro;
            DROP PROCEDURE IF EXISTS sp_update_suministro;
            DROP PROCEDURE IF EXISTS sp_delete_suministro;
        ');
    }
};
