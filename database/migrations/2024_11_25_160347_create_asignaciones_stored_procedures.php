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

            CREATE PROCEDURE sp_insert_asignacion(
                IN p_id_equipo INT,
                IN p_id_sucursal INT,
                IN p_id_area INT,
                IN p_cod_empleados INT,
                IN p_id_suministro INT,
                IN p_detalle_asignacion VARCHAR(100),
                IN p_fecha_asignacion DATE,
                IN p_fecha_devolucion DATE
            )
            BEGIN
                -- Validar si el equipo existe
                IF NOT EXISTS (SELECT 1 FROM equipos WHERE id_equipo = p_id_equipo) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: El equipo no existe.";
                END IF;

                -- Validar si la sucursal existe
                IF NOT EXISTS (SELECT 1 FROM sucursales WHERE id_sucursal = p_id_sucursal) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La sucursal no existe.";
                END IF;
                
               
                 -- Validar si el empleado existe, si se proporciona
                IF p_cod_empleados IS NOT NULL THEN
                   IF NOT EXISTS (SELECT 1 FROM empleados WHERE cod_empleados = p_cod_empleados) THEN
                     SIGNAL SQLSTATE "45000"
                     SET MESSAGE_TEXT = "Error: El empleado no existe.";
                   END IF;
                END IF;

                -- Validar la coherencia de fechas
                IF p_fecha_asignacion > p_fecha_devolucion THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La fecha de asignación no puede ser posterior a la fecha de devolución.";
                END IF;

                -- Insertar en asignaciones
                INSERT INTO asignaciones (
                    id_equipo, id_sucursal, id_area, cod_empleados, id_suministro, detalle_asignacion, fecha_asignacion, fecha_devolucion
                ) VALUES (
                    p_id_equipo, p_id_sucursal, p_id_area, p_cod_empleados, p_id_suministro, p_detalle_asignacion, p_fecha_asignacion, p_fecha_devolucion
                );
            END;

            CREATE PROCEDURE sp_update_asignacion(
                IN p_id_asignacion INT,
                IN p_id_equipo INT,
                IN p_id_sucursal INT,
                IN p_id_area INT,
                IN p_cod_empleados INT,
                IN p_id_suministro INT,
                IN p_detalle_asignacion VARCHAR(100),
                IN p_fecha_asignacion DATE,
                IN p_fecha_devolucion DATE
            )
            BEGIN
                -- Validar si la asignación existe
                IF NOT EXISTS (SELECT 1 FROM asignaciones WHERE id_asignacion = p_id_asignacion) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La asignación no existe.";
                END IF;

                -- Validar si el equipo existe
                IF NOT EXISTS (SELECT 1 FROM equipos WHERE id_equipo = p_id_equipo) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: El equipo no existe.";
                END IF;
                
                 -- Validar si la sucursal existe
                IF NOT EXISTS (SELECT 1 FROM sucursales WHERE id_sucursal = p_id_sucursal) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La sucursal no existe.";
                END IF;

                -- Validar si el empleado existe
                IF NOT EXISTS (SELECT 1 FROM empleados WHERE cod_empleados = p_cod_empleados) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: El empleado no existe.";
                END IF;


                -- Validar la coherencia de fechas
                IF p_fecha_asignacion > p_fecha_devolucion THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La fecha de asignación no puede ser posterior a la fecha de devolución.";
                END IF;

                -- Actualizar la asignación
                UPDATE asignaciones
                SET 
                    id_equipo = p_id_equipo,
                    id_sucursal = p_id_sucursal,
                    id_area = p_id_area,
                    cod_empleados = p_cod_empleados,
                    id_suministro = p_id_suministro,
                    detalle_asignacion = p_detalle_asignacion,
                    fecha_asignacion = p_fecha_asignacion,
                    fecha_devolucion = p_fecha_devolucion
                WHERE id_asignacion = p_id_asignacion;
            END;

            CREATE PROCEDURE sp_delete_asignacion (
                IN p_id_asignacion INT
            )
            BEGIN
                -- Validar si la asignación existe
                IF NOT EXISTS (SELECT 1 FROM asignaciones WHERE id_asignacion = p_id_asignacion) THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error: La asignación no existe.";
                END IF;

                -- Eliminar la asignación
                DELETE FROM asignaciones
                WHERE id_asignacion = p_id_asignacion;
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
