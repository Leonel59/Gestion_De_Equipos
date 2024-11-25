<?php

namespace App\Reports;

use \koolreport\KoolReport;
use \koolreport\laravel\Friendship;

class EmpleadosReport extends KoolReport
{
    use Friendship;

    // Definir la fuente de datos
    protected function settings()
    {
        return [
            'dataSources' => [
                'mysql' => [
                    'connectionString' => "mysql:host=127.0.0.1;dbname=lavarellogin", // Cambia por tu base de datos
                    'username' => "root", // Cambia por tu usuario de base de datos
                    'password' => "", // Cambia por tu contraseña
                    'charset' => 'utf8',
                ],
            ],
        ];
    }

    // Configurar los datos para el reporte
    protected function setup()
    {
        // Hacemos un JOIN con las tablas de sucursales y áreas para traer los nombres
        $this->src('mysql')
            ->query("SELECT 
                        empleados.cod_empleados, 
                        empleados.id_sucursal, 
                        empleados.id_area, 
                        empleados.nombre_empleado, 
                        empleados.apellido_empleado, 
                        empleados.cargo_empleado, 
                        empleados.estado_empleado, 
                        empleados.fecha_contratacion, 
                        sucursales.nombre_sucursal,  -- Traemos el nombre de la sucursal
                        areas.nombre_area            -- Traemos el nombre del área
                    FROM empleados
                    LEFT JOIN sucursales ON empleados.id_sucursal = sucursales.id_sucursal
                    LEFT JOIN areas ON empleados.id_area = areas.id_area")
            ->pipe($this->dataStore('empleados')); // Guardamos los datos en el dataStore
    }

    // Método para obtener los datos del reporte
    public function getEmpleados()
    {
        // Accede a los datos almacenados en 'empleados' y devuelve los resultados usando 'data()'
        return $this->dataStore('empleados')->data(); 
    }
}
