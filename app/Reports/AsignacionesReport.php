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
                    equipos.cod_equipo AS equipo,
                    CONCAT(empleados.nombre_empleado, ' ', empleados.apellido_empleado) AS empleado,
                    sucursales.nombre_sucursal AS sucursal,
                    areas.nombre_area AS area,
                    asignaciones.detalle_asignacion AS detalles_asignacion,
                    asignaciones.fecha_asignacion AS fecha_asignacion,
                    asignaciones.fecha_devolucion AS fecha_devolucion
                FROM asignaciones
                LEFT JOIN equipos ON asignaciones.id_equipo = equipos.id_equipo
                LEFT JOIN empleados ON asignaciones.cod_empleados = empleados.cod_empleados
                LEFT JOIN sucursales ON asignaciones.id_sucursal = sucursales.id_sucursal
                LEFT JOIN areas ON asignaciones.id_area = areas.id_area
            ")
            ->pipe($this->dataStore('asignaciones')); // Guardamos los datos en el dataStore
    }

    // Método para obtener los datos del reporte
    public function getAsignaciones()
    {
        return $this->dataStore('asignaciones')->data();
    }
}
