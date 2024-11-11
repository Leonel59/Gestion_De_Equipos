<?php

namespace App\Reports;

use \koolreport\KoolReport;
use \koolreport\laravel\Friendship;

class EquiposReport extends KoolReport
{
    use Friendship;

    // Definir la fuente de datos
    protected function settings()
    {
        return [
            'dataSources' => [
                'mysql' => [
                    'connectionString' => "mysql:host=127.0.0.1;dbname=lavarellogin",
                    'username' => "root",
                    'password' => "",
                    'charset' => 'utf8',
                ],
            ],
        ];
    }

    // Configurar los datos para el reporte
    protected function setup()
    {
        $this->src('mysql')
            ->query("SELECT * FROM equipos") // Ajusta el nombre de la tabla si es necesario
            ->pipe($this->dataStore('equipos')); // Guardar los datos en el dataStore
    }

    // Método para obtener los datos del reporte
    public function getEquipos()
    {
        // Accede a los datos almacenados en 'equipos' y devuelve los resultados usando 'data()'
        return $this->dataStore('equipos')->data(); 
    }
}
