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
        // Crear los procedimientos almacenados
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_servicio_mantenimiento;
            DROP PROCEDURE IF EXISTS sp_update_servicio_mantenimiento;
            DROP PROCEDURE IF EXISTS sp_delete_servicio_mantenimiento;

            CREATE PROCEDURE sp_insert_servicio_mantenimiento (
                IN p_id_equipo_mant VARCHAR(10),
                IN p_tipo_mantenimiento VARCHAR(255),
                IN p_descripcion_mantenimiento VARCHAR(200),
                IN p_cantidad_equipo_usado INT,
                IN p_fecha_reparacion_equipo DATE,
                IN p_fecha_entrega_equipo DATE,
                IN p_costo_mantenimiento DECIMAL(10, 2),
                IN p_duracion_mantenimiento INT,
                IN p_fecha_creacion DATE,
                IN p_modificado_por VARCHAR(100),
                IN p_fecha_modificacion DATE
            )
            BEGIN
                INSERT INTO servicios_mantenimientos (
                    id_equipo_mant,
                    tipo_mantenimiento,
                    descripcion_mantenimiento,
                    cantidad_equipo_usado,
                    fecha_reparacion_equipo,
                    fecha_entrega_equipo,
                    costo_mantenimiento,
                    duracion_mantenimiento,
                    fecha_creacion,
                    modificado_por,
                    fecha_modificacion
                ) VALUES (
                    p_id_equipo_mant,
                    p_tipo_mantenimiento,
                    p_descripcion_mantenimiento,
                    p_cantidad_equipo_usado,
                    p_fecha_reparacion_equipo,
                    p_fecha_entrega_equipo,
                    p_costo_mantenimiento,
                    p_duracion_mantenimiento,
                    p_fecha_creacion,
                    p_modificado_por,
                    p_fecha_modificacion
                );
            END;

            CREATE PROCEDURE sp_update_servicio_mantenimiento (
                IN p_id_mant INT,
                IN p_id_equipo_mant VARCHAR(10),
                IN p_tipo_mantenimiento VARCHAR(255),
                IN p_descripcion_mantenimiento VARCHAR(200),
                IN p_cantidad_equipo_usado INT,
                IN p_fecha_reparacion_equipo DATE,
                IN p_fecha_entrega_equipo DATE,
                IN p_costo_mantenimiento DECIMAL(10, 2),
                IN p_duracion_mantenimiento INT,
                IN p_fecha_creacion DATE,
                IN p_modificado_por VARCHAR(100),
                IN p_fecha_modificacion DATE
            )
            BEGIN
                UPDATE servicios_mantenimientos SET
                    id_equipo_mant = p_id_equipo_mant,
                    tipo_mantenimiento = p_tipo_mantenimiento,
                    descripcion_mantenimiento = p_descripcion_mantenimiento,
                    cantidad_equipo_usado = p_cantidad_equipo_usado,
                    fecha_reparacion_equipo = p_fecha_reparacion_equipo,
                    fecha_entrega_equipo = p_fecha_entrega_equipo,
                    costo_mantenimiento = p_costo_mantenimiento,
                    duracion_mantenimiento = p_duracion_mantenimiento,
                    fecha_creacion = p_fecha_creacion,
                    modificado_por = p_modificado_por,
                    fecha_modificacion = p_fecha_modificacion
                WHERE id_mant = p_id_mant;
            END;

            CREATE PROCEDURE sp_delete_servicio_mantenimiento (
                IN p_id_mant INT
            )
            BEGIN
                DELETE FROM servicios_mantenimientos WHERE id_mant = p_id_mant;
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
            DROP PROCEDURE IF EXISTS sp_insert_servicio_mantenimiento;
            DROP PROCEDURE IF EXISTS sp_update_servicio_mantenimiento;
            DROP PROCEDURE IF EXISTS sp_delete_servicio_mantenimiento;
        ');
    }
};

