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
    // Realizamos JOIN entre las tablas proveedor, factura, direcciones, telefonos y correos
    $this->src('mysql')
        ->query("SELECT 
                    p.nombre_proveedor,
                    p.rtn_proveedor,
                    p.contacto_proveedor,
                    d.direccion AS direccion_proveedor, -- Dirección del proveedor
                    d.ciudad AS ciudad_proveedor, -- Ciudad del proveedor
                    d.departamento AS departamento_proveedor, -- Departamento del proveedor
                    t.telefono_personal, -- Teléfono personal
                    c.correo_personal, -- Correo personal
                    f.tipo_factura,
                    f.fecha_facturacion
                FROM proveedor AS p
                LEFT JOIN factura AS f ON p.id_proveedor = f.id_proveedor
                LEFT JOIN direcciones AS d ON p.id_proveedor = d.id_proveedor -- Relación con direcciones
                LEFT JOIN telefonos AS t ON p.id_proveedor = t.id_proveedor -- Relación con telefonos
                LEFT JOIN correos AS c ON p.id_proveedor = c.id_proveedor -- Relación con correos")
        ->pipe($this->dataStore('proveedor_factura')); // Guardar los datos en el dataStore
}


    // Método para obtener los datos del reporte
    public function getProveedorFactura()
    {
        // Accede a los datos almacenados en 'proveedor_factura' y devuelve los resultados usando 'data()'
        return $this->dataStore('proveedor_factura')->data(); 
    }
}
