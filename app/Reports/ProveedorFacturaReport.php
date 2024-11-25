<?php

namespace App\Reports;

use \koolreport\KoolReport;
use \koolreport\laravel\Friendship;

class ProveedorFacturaReport extends KoolReport
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
        // Realizamos un JOIN entre las tablas proveedor y factura
        $this->src('mysql')
            ->query("SELECT 
                        p.nombre_proveedor,
                        p.rtn_proveedor,
                        p.contacto_proveedor,
                        p.direccion_proveedor,
                        p.telefono_proveedor,
                        p.email_proveedor,
                        f.tipo_factura,
                        f.fecha_facturacion
                    FROM proveedor AS p
                    LEFT JOIN factura AS f ON p.id_proveedor = f.id_proveedor")
            ->pipe($this->dataStore('proveedor_factura')); // Guardar los datos en el dataStore
    }

    // Método para obtener los datos del reporte
    public function getProveedorFactura()
    {
        // Accede a los datos almacenados en 'proveedor_factura' y devuelve los resultados usando 'data()'
        return $this->dataStore('proveedor_factura')->data(); 
    }
}
