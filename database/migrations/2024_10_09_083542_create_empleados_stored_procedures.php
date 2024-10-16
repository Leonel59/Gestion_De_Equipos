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
            DROP PROCEDURE IF EXISTS sp_insert_empleado;
            DROP PROCEDURE IF EXISTS sp_update_empleado;
            DROP PROCEDURE IF EXISTS sp_delete_empleado;

            CREATE PROCEDURE sp_insert_empleado (
                IN p_cod_empleado VARCHAR(255),
                IN p_correo VARCHAR(255),
                IN p_telefono VARCHAR(20),
                IN p_direccion VARCHAR(255),
                IN p_sucursal VARCHAR(255),
                IN p_area VARCHAR(255),
                IN p_dni_empleado VARCHAR(20),
                IN p_nombre_empleado VARCHAR(100),
                IN p_apellido_empleado VARCHAR(100),
                IN p_cargo_empleado VARCHAR(100),
                IN p_fecha_contratacion DATE,
                IN p_sexo_empleado ENUM("masculino", "femenino", "otro")
            )
            BEGIN
                INSERT INTO empleados (
                    cod_empleado,
                    correo,
                    telefono,
                    direccion,
                    sucursal,
                    area,
                    dni_empleado,
                    nombre_empleado,
                    apellido_empleado,
                    cargo_empleado,
                    fecha_contratacion,
                    sexo_empleado
                ) VALUES (
                    p_cod_empleado,
                    p_correo,
                    p_telefono,
                    p_direccion,
                    p_sucursal,
                    p_area,
                    p_dni_empleado,
                    p_nombre_empleado,
                    p_apellido_empleado,
                    p_cargo_empleado,
                    p_fecha_contratacion,
                    p_sexo_empleado
                );
            END;

            CREATE PROCEDURE sp_update_empleado (
                IN p_id BIGINT,
                IN p_cod_empleado VARCHAR(255),
                IN p_correo VARCHAR(255),
                IN p_telefono VARCHAR(20),
                IN p_direccion VARCHAR(255),
                IN p_sucursal VARCHAR(255),
                IN p_area VARCHAR(255),
                IN p_dni_empleado VARCHAR(20),
                IN p_nombre_empleado VARCHAR(100),
                IN p_apellido_empleado VARCHAR(100),
                IN p_cargo_empleado VARCHAR(100),
                IN p_fecha_contratacion DATE,
                IN p_sexo_empleado ENUM("masculino", "femenino", "otro")
            )
            BEGIN
                UPDATE empleados SET
                    cod_empleado = p_cod_empleado,
                    correo = p_correo,
                    telefono = p_telefono,
                    direccion = p_direccion,
                    sucursal = p_sucursal,
                    area = p_area,
                    dni_empleado = p_dni_empleado,
                    nombre_empleado = p_nombre_empleado,
                    apellido_empleado = p_apellido_empleado,
                    cargo_empleado = p_cargo_empleado,
                    fecha_contratacion = p_fecha_contratacion,
                    sexo_empleado = p_sexo_empleado
                WHERE id = p_id;
            END;

            CREATE PROCEDURE sp_delete_empleado (
                IN p_id BIGINT
            )
            BEGIN
                DELETE FROM empleados WHERE id = p_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_empleado;
            DROP PROCEDURE IF EXISTS sp_update_empleado;
            DROP PROCEDURE IF EXISTS sp_delete_empleado;
        ');
    }
};

