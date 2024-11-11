<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reports\EquiposReport;

class ReportController extends Controller
{
    public function index()
    {
        $report = new EquiposReport;
        $report->run();
    
        $equipos = $report->dataStore('equipos')->toArray(); 
        return view('reports.index', ['equipos' => $equipos]);
    }

    public function equiposReport()
{
    // Crear la instancia del reporte
    $report = new EquiposReport;

    // Ejecutar el reporte para cargar los datos
    $report->run();

    // Obtener los equipos del dataStore
    $equipos = $report->dataStore('equipos')->toArray(); // Accede a los datos usando toArray()

     // Redirigir al índice con los reportes generados
     return view('reports.equipos', ['equipos' => $equipos, 'report' => $report]);
}

}
