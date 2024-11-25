<?php

namespace App\Reports;

use \koolreport\KoolReport;
use \koolreport\laravel\Friendship;

class ServicioMantenimientoReport extends KoolReport
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
        // Hacemos JOIN con las tablas de equipos y producto_mantenimiento
        $this->src('mysql')
            ->query("SELECT 
                        sm.id_mant,
                        sm.id_equipo_mant,
                        sm.tipo_mantenimiento,
                        sm.descripcion_mantenimiento,
                        sm.cantidad_equipo_usado,
                        sm.duracion_mantenimiento,
                        sm.fecha_reparacion_equipo,
                        sm.fecha_entrega_equipo,
                        sm.costo_mantenimiento,
                        pm.nombre_producto,
                        pm.cantidad_producto,
                        pm.costo_producto
                    FROM servicios_mantenimientos AS sm
                    LEFT JOIN producto_mantenimiento AS pm ON sm.id_mant = pm.servicio_mantenimiento_id
                    LEFT JOIN equipos AS e ON sm.id_equipo_mant = e.cod_equipo") // Incluimos el nombre del equipo si lo necesitas
            ->pipe($this->dataStore('servicio_mantenimiento')); // Guardar los datos en el dataStore
    }

    // Método para obtener los datos del reporte
    public function getServiciosMantenimiento()
    {
        // Accede a los datos almacenados en 'servicio_mantenimiento' y devuelve los resultados usando 'data()'
        return $this->dataStore('servicio_mantenimiento')->data(); 
    }
}
