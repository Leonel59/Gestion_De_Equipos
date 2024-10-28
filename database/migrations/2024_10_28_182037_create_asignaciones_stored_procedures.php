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
            DROP PROCEDURE IF EXISTS sp_insert_asignacion;
            DROP PROCEDURE IF EXISTS sp_update_asignacion;
            DROP PROCEDURE IF EXISTS sp_delete_asignacion;

            CREATE PROCEDURE sp_insert_asignacion (
                IN p_cod_empleados VARCHAR(255),
                IN p_sucursal VARCHAR(255),
                IN p_detalle_asignacion VARCHAR(100),
                IN p_fecha_asignacion DATETIME,
                IN p_fecha_devolucion DATETIME
            )
            BEGIN
                INSERT INTO asignaciones (
                    cod_empleados,
                    sucursal,
                    detalle_asignacion,
                    fecha_asignacion,
                    fecha_devolucion
                ) VALUES (
                    p_cod_empleados,
                    p_sucursal,
                    p_detalle_asignacion,
                    p_fecha_asignacion,
                    p_fecha_devolucion
                );
            END;

            CREATE PROCEDURE sp_update_asignacion (
                IN p_id_asignacion BIGINT,
                IN p_cod_empleados VARCHAR(255),
                IN p_sucursal VARCHAR(255),
                IN p_detalle_asignacion VARCHAR(100),
                IN p_fecha_asignacion DATETIME,
                IN p_fecha_devolucion DATETIME
            )
            BEGIN
                UPDATE asignaciones SET
                    cod_empleados = p_cod_empleados,
                    sucursal = p_sucursal,
                    detalle_asignacion = p_detalle_asignacion,
                    fecha_asignacion = p_fecha_asignacion,
                    fecha_devolucion = p_fecha_devolucion
                WHERE id_asignacion = p_id_asignacion;
            END;

            CREATE PROCEDURE sp_delete_asignacion (
                IN p_id_asignacion BIGINT
            )
            BEGIN
                DELETE FROM asignaciones WHERE id_asignacion = p_id_asignacion;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_asignacion;
            DROP PROCEDURE IF EXISTS sp_update_asignacion;
            DROP PROCEDURE IF EXISTS sp_delete_asignacion;
        ');
    }
};
