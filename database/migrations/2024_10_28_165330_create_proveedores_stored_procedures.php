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
                IN p_correo_personal VARCHAR(100),
                IN p_correo_profesional VARCHAR(100),
                IN p_telefono_personal VARCHAR(25),
                IN p_telefono_trabajo VARCHAR(25),
                IN p_direccion VARCHAR(255),
                IN p_departamento ENUM(\'Francisco Morazan\', \'Olancho\',\'Comayagua\', \'El Paraiso\', \'Intibuca\', \'Lempira\', \'Choluteca\', \'La Paz\'),
                IN p_ciudad VARCHAR(100)
            )
            BEGIN
              DECLARE p_id_proveedor INT;

                INSERT INTO proveedor (
                    nombre_proveedor,
                    rtn_proveedor,
                    contacto_proveedor
                ) VALUES (
                    p_nombre_proveedor,
                    p_rtn_proveedor,
                    p_contacto_proveedor
                );


                SET p_id_proveedor = LAST_INSERT_ID();

                INSERT INTO correos (correo_personal, correo_profesional, id_proveedor)
                VALUES (p_correo_personal, p_correo_profesional, p_id_proveedor);
    

                INSERT INTO telefonos (telefono_personal, telefono_trabajo, id_proveedor)
                VALUES (p_telefono_personal, p_telefono_trabajo, p_id_proveedor);


                INSERT INTO direcciones (departamento, ciudad, direccion, id_proveedor)
                VALUES (p_departamento, p_ciudad, p_direccion, p_id_proveedor);

            END;

            CREATE PROCEDURE sp_update_proveedor (
                IN p_id_proveedor INT,
                IN p_nombre_proveedor VARCHAR(100),
                IN p_rtn_proveedor VARCHAR(100),
                IN p_contacto_proveedor VARCHAR(50),
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

                UPDATE proveedor SET
                    nombre_proveedor = p_nombre_proveedor,
                    rtn_proveedor = p_rtn_proveedor,
                    contacto_proveedor = p_contacto_proveedor,
                    updated_at = NOW()
                WHERE id_proveedor = p_id_proveedor;


                -- Actualizar en la tabla correos
    UPDATE correos 
    SET 
        correo_personal = p_correo_personal,
        correo_profesional = CASE WHEN p_correo_profesional IS NULL THEN NULL ELSE p_correo_profesional END
    WHERE id_proveedor = p_id_proveedor;

    -- Actualizar en la tabla telefonos
    UPDATE telefonos 
    SET 
        telefono_personal = p_telefono_personal,
      telefono_trabajo = CASE WHEN p_telefono_trabajo IS NULL THEN NULL ELSE p_telefono_trabajo END
    WHERE id_proveedor = p_id_proveedor;

    -- Actualizar en la tabla direcciones
    UPDATE direcciones 
    SET 
        departamento = p_departamento,
        ciudad = p_ciudad,
        direccion = p_direccion
    WHERE id_proveedor = p_id_proveedor;

    -- Confirmar transacción
    COMMIT;
END;
           

           
             CREATE PROCEDURE sp_delete_proveedor(
                IN p_id_proveedor INT
            )
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM proveedor WHERE id_proveedor = p_id_proveedor) THEN
                    SIGNAL SQLSTATE \'45000\' SET MESSAGE_TEXT = \'El proveedor no existe.\';
                ELSE
                    DELETE FROM proveedor WHERE id_proveedor = p_id_proveedor;
                END IF;
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

