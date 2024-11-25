<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reports\EquiposReport;
use App\Reports\EmpleadosReport; // Agregar el reporte de empleados
use App\Reports\ServicioMantenimientoReport;
use App\Reports\AsignacionesReport;
use App\Reports\ProveedorFacturaReport; 

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
        // Crear la instancia del reporte de equipos
        $report = new EquiposReport;

        // Ejecutar el reporte para cargar los datos
        $report->run();

        // Obtener los equipos del dataStore
        $equipos = $report->dataStore('equipos')->toArray(); // Accede a los datos usando toArray()

        // Redirigir al índice con los reportes generados
        return view('reports.equipos', ['equipos' => $equipos, 'report' => $report]);
    }

    // Agregar el método para el reporte de empleados
    public function empleadosReport()
    {
        // Crear la instancia del reporte de empleados
        $report = new EmpleadosReport; // Usar el reporte de empleados

        // Ejecutar el reporte para cargar los datos
        $report->run();

        // Obtener los empleados del dataStore
        $empleados = $report->dataStore('empleados')->toArray(); // Accede a los datos usando toArray()

        // Redirigir al índice con los reportes generados
        return view('reports.empleados', ['empleados' => $empleados, 'report' => $report]);
    }

    // Método para el reporte de servicios de mantenimiento
    public function ServicioMantenimientoReport()
    {
        // Crear la instancia del reporte de servicios de mantenimiento
        $report = new ServicioMantenimientoReport;

        // Ejecutar el reporte para cargar los datos
        $report->run();

        // Obtener los servicios de mantenimiento del dataStore
        $servicios = $report->dataStore('servicio_mantenimiento')->toArray();

        // Redirigir a la vista correspondiente con los datos
        return view('reports.servicios', ['servicios' => $servicios, 'report' => $report]);
    }

     // Método para el reporte de proveedores con facturas
     public function proveedorFacturaReport()
     {
         // Crear la instancia del reporte de proveedores con facturas
         $report = new ProveedorFacturaReport;
 
         // Ejecutar el reporte para cargar los datos
         $report->run();
 
         // Obtener los proveedores con sus facturas desde el dataStore
         $proveedores = $report->dataStore('proveedor_factura')->toArray();
 
         // Redirigir a la vista correspondiente con los datos
         return view('reports.proveedores', ['proveedores' => $proveedores, 'report' => $report]);
     }

     // Agregar el método para el reporte de asignaciones
    public function asignacionesReport()
    {
        // Crear la instancia del reporte de asignaciones
        $report = new AsignacionesReport;

        // Ejecutar el reporte para cargar los datos
        $report->run();

        // Obtener las asignaciones del dataStore
        $asignaciones = $report->dataStore('asignaciones')->toArray();

        // Redirigir a la vista correspondiente con los datos
        return view('reports.asignaciones', ['asignaciones' => $asignaciones, 'report' => $report]);
    }

}

