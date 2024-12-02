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
            DROP PROCEDURE IF EXISTS sp_insert_equipos;
            DROP PROCEDURE IF EXISTS sp_update_equipos;
            DROP PROCEDURE IF EXISTS sp_delete_equipos;

CREATE PROCEDURE sp_insert_equipos(
    IN p_estado_equipo ENUM("Disponible", "En Mantenimiento", "Comodin", "Asignado"),
    IN p_tipo_equipo ENUM("Computadora", "Impresora", "Otro"),
    IN p_cod_equipo VARCHAR(10),
    IN p_marca_equipo VARCHAR(100),
    IN p_modelo_equipo VARCHAR(100),
    IN p_numero_serie VARCHAR(100),
    IN p_precio_equipo DECIMAL(10, 2),
    IN p_fecha_adquisicion DATE,
    IN p_serie_cargador_comp VARCHAR(50),
    IN p_procesador_comp VARCHAR(50),
    IN p_memoria_comp VARCHAR(20),
    IN p_tarjeta_grafica_comp VARCHAR(50),
    IN p_tipodisco_comp VARCHAR(50),
    IN p_sistema_operativo_comp VARCHAR(100),
    IN p_tipo_impresora VARCHAR(50),
    IN p_resolucion_impresora VARCHAR(30),
    IN p_conectividad_impresora VARCHAR(50),
    IN p_capacidad VARCHAR(50),
    IN p_tamano VARCHAR(50),
    IN p_color VARCHAR(30)
)
BEGIN
    DECLARE v_id_equipo INT;
    DECLARE v_depreciacion_anual DECIMAL(10, 2);
    DECLARE v_depreciacion_acumulada DECIMAL(10, 2);
    DECLARE v_valor_residual DECIMAL(10, 2);
    DECLARE v_vida_util INT DEFAULT 5;

    -- Validaciones del estado
    IF p_estado_equipo NOT IN ("Disponible", "En Mantenimiento", "Comodin", "Asignado") THEN
        SIGNAL SQLSTATE "45000" 
        SET MESSAGE_TEXT = "Error: El estado de equipo debe ser Disponible, En Mantenimiento y No Disponible.";
    END IF;

    -- Validaciones
    IF p_precio_equipo <= 0 THEN
        SIGNAL SQLSTATE "45000" 
        SET MESSAGE_TEXT = "Error: El precio del equipo debe ser mayor que cero.";
    END IF;

    IF p_tipo_equipo = "Computadora" THEN
        IF p_serie_cargador_comp IS NULL OR p_procesador_comp IS NULL OR p_memoria_comp IS NULL 
            OR p_tipodisco_comp IS NULL OR p_sistema_operativo_comp IS NULL THEN
            SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Faltan Propiedades de Computadora.";
        END IF;
    ELSEIF p_tipo_equipo = "Impresora" THEN
        IF p_tipo_impresora IS NULL OR p_resolucion_impresora IS NULL OR 
           p_conectividad_impresora IS NULL THEN
            SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Faltan Propiedades de Impresora.";
        END IF;
    ELSEIF p_tipo_equipo = "Otro" THEN
        IF p_capacidad IS NULL OR p_tamano IS NULL OR p_color IS NULL THEN
            SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Faltan Propiedades de Otro Equipo.";
        END IF;
    END IF;

    -- Cálculo de depreciación
    SET v_valor_residual = p_precio_equipo / v_vida_util;
    SET v_depreciacion_anual = (p_precio_equipo- v_valor_residual) / v_vida_util;
    SET v_depreciacion_acumulada = DATEDIFF(NOW(), p_fecha_adquisicion) / 365 * v_depreciacion_anual;
    IF v_depreciacion_acumulada > (p_precio_equipo - v_valor_residual) THEN
        SET v_depreciacion_acumulada = p_precio_equipo - v_valor_residual;
    END IF;

    -- Insertar en equipos
    INSERT INTO equipos (
        estado_equipo, tipo_equipo, cod_equipo,
        marca_equipo, modelo_equipo, numero_serie, 
        precio_equipo, fecha_adquisicion, depreciacion_equipo
    ) VALUES (
        p_estado_equipo, p_tipo_equipo, p_cod_equipo, 
        p_marca_equipo, p_modelo_equipo, p_numero_serie, 
        p_precio_equipo, p_fecha_adquisicion, v_depreciacion_acumulada
    );

    SET v_id_equipo = LAST_INSERT_ID();

    -- Insertar propiedades según el tipo de equipo
    IF p_tipo_equipo = "Computadora" THEN
        INSERT INTO propiedades_computadoras (
            id_equipo, serie_cargador_comp, procesador_comp, memoria_comp, tarjeta_grafica_comp, tipodisco_comp, sistema_operativo_comp
        ) VALUES (
            v_id_equipo, p_serie_cargador_comp, p_procesador_comp, p_memoria_comp, p_tarjeta_grafica_comp, p_tipodisco_comp, p_sistema_operativo_comp
        );
    ELSEIF p_tipo_equipo = "Impresora" THEN
        INSERT INTO propiedades_impresoras (
            id_equipo, tipo_impresora, resolucion_impresora, conectividad_impresora
        ) VALUES (
            v_id_equipo, p_tipo_impresora, p_resolucion_impresora, p_conectividad_impresora
        );
    ELSEIF p_tipo_equipo = "Otro" THEN
        INSERT INTO propiedades_otroequipo (
            id_equipo, capacidad, tamano, color
        ) VALUES (
            v_id_equipo, p_capacidad, p_tamano, p_color
        );
    END IF;
END;


            CREATE PROCEDURE sp_update_equipos(
                IN p_id_equipo INT,
                IN p_estado_equipo ENUM("Disponible", "En Mantenimiento", "Comodin", "Asignado" ),
                IN p_tipo_equipo ENUM("Computadora", "Impresora", "Otro"),
                IN p_cod_equipo VARCHAR(10),
                IN p_marca_equipo VARCHAR(100),
                IN p_modelo_equipo VARCHAR(100),
                IN p_numero_serie VARCHAR(100),
                IN p_precio_equipo DECIMAL(10, 2),
                IN p_fecha_adquisicion DATE,
                IN p_serie_cargador_comp VARCHAR(50),
                IN p_procesador_comp VARCHAR(50),
                IN p_memoria_comp VARCHAR(20),
                IN p_tarjeta_grafica_comp VARCHAR(50),
                IN p_tipodisco_comp VARCHAR(50),
                IN p_sistema_operativo_comp VARCHAR(100),
                IN p_tipo_impresora VARCHAR(50),
                IN p_resolucion_impresora VARCHAR(30),
                IN p_conectividad_impresora VARCHAR(50),
                IN p_capacidad VARCHAR(50),
                IN p_tamano VARCHAR(50),
                IN p_color VARCHAR(30)
            )
            BEGIN
                DECLARE v_depreciacion_anual DECIMAL(10, 2);
                DECLARE v_depreciacion_acumulada DECIMAL(10, 2);
                DECLARE v_valor_residual DECIMAL(10, 2);
                DECLARE v_vida_util INT DEFAULT 5;

        

                IF p_precio_equipo <= 0 THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Error: El precio del equipo debe ser mayor que cero.";
                END IF;

                 -- Validaciones adicionales para propiedades específicas de cada tipo
                IF p_tipo_equipo = "Computadora" THEN
                    IF p_serie_cargador_comp IS NULL OR p_procesador_comp IS NULL OR p_memoria_comp IS NULL 
                        OR p_tipodisco_comp IS NULL OR p_sistema_operativo_comp IS NULL THEN
                        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Faltan Propiedades de Computadora.";
                    END IF;
                ELSEIF p_tipo_equipo = "Impresora" THEN
                    IF p_tipo_impresora IS NULL OR p_resolucion_impresora IS NULL OR 
                       p_conectividad_impresora IS NULL THEN
                        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Faltan Propiedades de Impresora.";
                    END IF;
                ELSEIF p_tipo_equipo = "Otro" THEN
                    IF p_capacidad IS NULL OR p_tamano IS NULL OR p_color IS NULL THEN
                        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Faltan Propiedades de Otro Equipo.";
                    END IF;
                END IF;

                -- Cálculo de depreciación
                SET v_valor_residual = p_precio_equipo / v_vida_util;
                SET v_depreciacion_anual = (p_precio_equipo- v_valor_residual) / v_vida_util;
                SET v_depreciacion_acumulada = DATEDIFF(NOW(), p_fecha_adquisicion) / 365 * v_depreciacion_anual;
                IF v_depreciacion_acumulada > (p_precio_equipo - v_valor_residual) THEN
                    SET v_depreciacion_acumulada = p_precio_equipo - v_valor_residual;
                END IF;


                -- Actualizar equipo en la tabla EQUIPOS
                UPDATE equipos
                SET 
                    estado_equipo = p_estado_equipo,
                    tipo_equipo = p_tipo_equipo,
                    cod_equipo = p_cod_equipo,
                    marca_equipo = p_marca_equipo,
                    modelo_equipo = p_modelo_equipo,
                    numero_serie = p_numero_serie,
                    precio_equipo = p_precio_equipo,
                    fecha_adquisicion = p_fecha_adquisicion,
                    depreciacion_equipo = v_DEPRECIACION_ACUMULADA
                WHERE id_equipo = p_id_equipo;

                -- Actualizar propiedades según el tipo de equipo
                IF p_tipo_equipo = "Computadora" THEN
                    UPDATE propiedades_computadoras
                    SET 
                        serie_cargador_comp = p_serie_cargador_comp,
                        procesador_comp = p_procesador_comp,
                        memoria_comp = p_memoria_comp,
                        tarjeta_grafica_comp = p_tarjeta_grafica_comp,
                        tipodisco_comp = p_tipodisco_comp,
                        sistema_operativo_comp = p_sistema_operativo_comp
                    WHERE id_equipo = p_id_equipo;
                ELSEIF p_tipo_equipo = "Impresora" THEN
                    UPDATE propiedades_impresoras
                    SET 
                        tipo_impresora = p_tipo_impresora,
                        resolucion_impresora = p_resolucion_impresora,
                        conectividad_impresora = p_conectividad_impresora
                    WHERE id_equipo = p_id_equipo;
                ELSEIF p_tipo_equipo = "Otro" THEN
                    UPDATE propiedades_otroequipo
                    SET 
                        capacidad = p_capacidad,
                        tamano = p_tamano,
                        color = p_color
                    WHERE id_equipo = p_id_equipo;
                END IF;
            END;


            CREATE PROCEDURE sp_delete_equipos (
              IN p_ID_EQUIPO INT
            )
            BEGIN
              DECLARE v_tipo_equipo ENUM("Computadora", "Impresora", "Otro");
              DECLARE v_id_estado INT;

              -- Verificar si el equipo existe
               IF NOT EXISTS (SELECT 1 FROM EQUIPOS WHERE id_equipo = p_ID_EQUIPO) THEN
                 SIGNAL SQLSTATE "45000" 
                 SET MESSAGE_TEXT = "Error: El equipo proporcionado no existe.";
               END IF;


              -- Eliminar las propiedades específicas según el tipo de equipo
               IF v_tipo_equipo = "Computadora" THEN
                  DELETE FROM propiedades_computadoras WHERE id_equipo = p_ID_EQUIPO;
               ELSEIF v_tipo_equipo = "Impresora" THEN
                 DELETE FROM propiedades_impresoras WHERE id_equipo = p_ID_EQUIPO;
              ELSEIF v_tipo_equipo = "Otro" THEN
                 DELETE FROM propiedades_otroequipo WHERE id_equipo = p_ID_EQUIPO;
               END IF;

             -- Eliminar el equipo de la tabla EQUIPOS
              DELETE FROM equipos WHERE id_equipo = p_ID_EQUIPO;

            END;

        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
        DB::unprepared('
         DROP PROCEDURE IF EXISTS sp_insert_equipos;
         DROP PROCEDURE IF EXISTS sp_update_equipos;
         DROP PROCEDURE IF EXISTS sp_delete_equipos;
        ');
    }
};