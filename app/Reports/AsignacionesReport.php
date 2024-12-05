<?php

namespace App\Reports;

use \koolreport\KoolReport;
use \koolreport\laravel\Friendship;

class AsignacionesReport extends KoolReport
{
    use Friendship;

    // Definir la configuración de la fuente de datos
    protected function settings()
    {
        return [
            'dataSources' => [
                'mysql' => [
                    'connectionString' => "mysql:host=127.0.0.1;dbname=lavarellogin", // Cambia por tu base de datos
                    'username' => "root", // Cambia por tu usuario
                    'password' => "", // Cambia por tu contraseña
                    'charset' => 'utf8',
                ],
            ],
        ];
    }

    // Configurar los datos para el reporte
    protected function setup()
    {
        // Query para obtener los datos de asignaciones con los nombres relacionados
        $this->src('mysql')
            ->query("
                   SELECT 
                CONCAT(equipos.cod_equipo, ' - ', equipos.tipo_equipo) AS equipo, -- Código del             equipo con el tipo
                CONCAT(empleados.nombre_empleado, ' ', empleados.apellido_empleado) AS empleado,
                sucursales.nombre_sucursal AS sucursal,
                areas.nombre_area AS area,
                asignaciones.detalle_asignacion AS detalles_asignacion,
                asignaciones.fecha_asignacion AS fecha_asignacion,
                asignaciones.fecha_devolucion AS fecha_devolucion,
                GROUP_CONCAT(suministros.nombre_suministro SEPARATOR ', ') AS suministros,
                equipos.precio_equipo AS precio_equipo,
                IFNULL(SUM(suministros.costo_unitario), 0) AS costo_suministros,
                (equipos.precio_equipo + IFNULL(SUM(suministros.costo_unitario), 0)) AS             costo_total_asignado
            FROM asignaciones
            LEFT JOIN equipos ON asignaciones.id_equipo = equipos.id_equipo
            LEFT JOIN empleados ON asignaciones.cod_empleados = empleados.cod_empleados
            LEFT JOIN sucursales ON asignaciones.id_sucursal = sucursales.id_sucursal
            LEFT JOIN areas ON asignaciones.id_area = areas.id_area
            LEFT JOIN asignacion_suministros ON asignaciones.id_asignacion =            asignacion_suministros.id_asignacion
            LEFT JOIN suministros ON asignacion_suministros.id_suministro = suministros.            id_suministro
            GROUP BY 
                equipo, -- Asegúrate de incluir la nueva columna en el GROUP BY
                empleado,
                sucursal,
                area,
                asignaciones.detalle_asignacion,
                asignaciones.fecha_asignacion,
                asignaciones.fecha_devolucion;
            ")
            ->pipe($this->dataStore('asignaciones')); // Guardamos los datos en el dataStore
    }

    // Método para obtener los datos del reporte
    public function getAsignaciones()
    {
        return $this->dataStore('asignaciones')->data();
    }
}