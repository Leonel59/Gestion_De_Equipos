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
            DROP PROCEDURE IF EXISTS sp_insert_empleados;
            DROP PROCEDURE IF EXISTS sp_update_empleados;
            DROP PROCEDURE IF EXISTS sp_delete_empleados;

           CREATE PROCEDURE sp_insert_empleados(
    IN p_id_sucursal INT,
    IN p_id_area INT,
    IN p_nombre_empleado VARCHAR(100),
    IN p_apellido_empleado VARCHAR(100),
    IN p_cargo_empleado VARCHAR(30),
    IN p_estado_empleado ENUM(\'Activo\', \'Inactivo\',\'Asignado\' ),
    IN p_fecha_contratacion DATE,
    
    -- parámetros para correos, teléfonos y direcciones
    IN p_correo_personal VARCHAR(100),
    IN p_correo_profesional VARCHAR(100),
    IN p_telefono_personal VARCHAR(25),
    IN p_telefono_trabajo VARCHAR(25),
    IN p_direccion VARCHAR(255),
    IN p_departamento ENUM(\'Francisco Morazan\', \'Olancho\',\'Comayagua\', \'El Paraiso\', \'Intibuca\', \'Lempira\', \'Choluteca\', \'La Paz\'),
    IN p_ciudad VARCHAR(100)
)
BEGIN
    DECLARE p_cod_empleados INT;

    -- Insertar en la tabla empleados
    INSERT INTO empleados (id_sucursal, id_area, nombre_empleado, apellido_empleado, cargo_empleado, estado_empleado, fecha_contratacion, fecha_modificacion)
    VALUES (p_id_sucursal, p_id_area, p_nombre_empleado, p_apellido_empleado, p_cargo_empleado, p_estado_empleado, p_fecha_contratacion, NOW());

    SET p_cod_empleados = LAST_INSERT_ID();

        INSERT INTO correos (correo_personal, correo_profesional, cod_empleados)
        VALUES (p_correo_personal, p_correo_profesional, p_cod_empleados);
    

        INSERT INTO telefonos (telefono_personal, telefono_trabajo, cod_empleados)
        VALUES (p_telefono_personal, p_telefono_trabajo, p_cod_empleados);


        INSERT INTO direcciones (departamento, ciudad, direccion, cod_empleados)
        VALUES (p_departamento, p_ciudad, p_direccion, p_cod_empleados);


END;

CREATE PROCEDURE sp_update_empleados(
    IN p_cod_empleados INT,
    IN p_id_sucursal INT,
    IN p_id_area INT,
    IN p_nombre_empleado VARCHAR(100),
    IN p_apellido_empleado VARCHAR(100),
    IN p_cargo_empleado VARCHAR(30),
    IN p_estado_empleado ENUM(\'Activo\', \'Inactivo\', \'Asignado\'),
    IN p_fecha_contratacion DATE,
    
    -- parámetros para correos, teléfonos y direcciones
    IN p_correo_personal VARCHAR(100),
    IN p_correo_profesional VARCHAR(100),
    IN p_telefono_personal VARCHAR(25),
    IN p_telefono_trabajo VARCHAR(25),
    IN p_direccion VARCHAR(255),
     IN p_departamento ENUM(\'Francisco Morazan\', \'Olancho\',\'Comayagua\', \'El Paraiso\', \'Intibuca\', \'Lempira\', \'Choluteca\', \'La Paz\'),
    IN p_ciudad VARCHAR(100)
)
BEGIN
    -- Iniciar transacción
    START TRANSACTION;
    
    -- Actualizar en la tabla empleados
    UPDATE empleados 
    SET 
        id_sucursal = p_id_sucursal,
        id_area = p_id_area,
        nombre_empleado = p_nombre_empleado,
        apellido_empleado = p_apellido_empleado,
        cargo_empleado = p_cargo_empleado,
        estado_empleado = p_estado_empleado,
        fecha_contratacion = p_fecha_contratacion,
        fecha_modificacion = NOW()
    WHERE cod_empleados = p_cod_empleados;

    -- Actualizar en la tabla correos
    UPDATE correos 
    SET 
        correo_personal = p_correo_personal,
        correo_profesional = CASE WHEN p_correo_profesional IS NULL THEN NULL ELSE p_correo_profesional END
    WHERE cod_empleados = p_cod_empleados;

    -- Actualizar en la tabla telefonos
    UPDATE telefonos 
    SET 
        telefono_personal = p_telefono_personal,
      telefono_trabajo = CASE WHEN p_telefono_trabajo IS NULL THEN NULL ELSE p_telefono_trabajo END
    WHERE cod_empleados = p_cod_empleados;

    -- Actualizar en la tabla direcciones
    UPDATE direcciones 
    SET 
        departamento = p_departamento,
        ciudad = p_ciudad,
        direccion = p_direccion
    WHERE cod_empleados = p_cod_empleados;

    -- Confirmar transacción
    COMMIT;
END;



            CREATE PROCEDURE sp_delete_empleados(
                IN pi_cod_empleado INT
            )
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM empleados WHERE cod_empleados = pi_cod_empleado) THEN
                    SIGNAL SQLSTATE \'45000\' SET MESSAGE_TEXT = \'El empleado no existe.\';
                ELSE
                    DELETE FROM empleados WHERE cod_empleados = pi_cod_empleado;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_insert_empleados;
            DROP PROCEDURE IF EXISTS sp_update_empleados;
            DROP PROCEDURE IF EXISTS sp_delete_empleados;
        ');
    }
};