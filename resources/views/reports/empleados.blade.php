@extends('adminlte::page')

@section('title', 'Reporte de Empleados')

@section('content')

<div class="row">
    <!-- Coloca el logo a la izquierda -->
    <div class="col-md-0">
        <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Empresa" class="img-fluid rounded-circle" style="max-width: 120px;">
    </div>

    <div class="col-md-8">
        <h1 class="font-weight-bold" style="font-size: 1.8rem; color: #003366; font-family: 'Arial', sans-serif;">Reporte de Empleados</h1>
        <p class="text-dark" style="font-size: 1.2rem; color: #003366; font-family: 'Roboto', sans-serif; font-weight: 20; letter-spacing: 1px; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);">
            Recarga Veloz
        </p>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-between">
        <div class="col-md-6 text-left">
            <p class="font-weight-bold" style="font-size: 1.1rem; color: #003366;">
                Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </p>
        </div>
        <div class="col-md-6 text-right">
            <p class="font-weight-bold" style="font-size: 1.1rem; color: #003366;">
                Dirección: Boulevard Suyapa, Tegucigalpa, Francisco Morazán
            </p>
        </div>
    </div>

    <!-- Botón para generar PDF -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <button id="download-pdf" class="btn btn-primary" style="font-size: 1.2rem;">
                Descargar PDF
            </button>
        </div>
    </div>

    <!-- Tabla de Empleados -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header" style="background-color: #003366; color: white;">
                    <h3 class="card-title font-weight-bold mb-0">Empleados Registrados</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered table-sm" style="border-radius: 5px;" id="empleados-table">
                        <thead class="thead-dark">
                            <tr>
                                
                                <th>Sucursal</th>
                                <th>Área</th>
                                <th>Nombre Empleado</th>
                                <th>Apellido Empleado</th>
                                <th>Cargo</th>
                                <th>Estado</th>
                                <th>Fecha Contratación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $empleado)
                                <tr>
                                    
                                    <td>{{ $empleado['nombre_sucursal'] }}</td>
                                    <td>{{ $empleado['nombre_area'] }}</td>
                                    <td>{{ $empleado['nombre_empleado'] }}</td>
                                    <td>{{ $empleado['apellido_empleado'] }}</td>
                                    <td>{{ $empleado['cargo_empleado'] }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($empleado['estado_empleado'] == 'Activo') badge-success 
                                            @elseif($empleado['estado_empleado'] == 'Inactivo') badge-danger 
                                            @endif">
                                            {{ $empleado['estado_empleado'] }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($empleado['fecha_contratacion'])->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <style>
        body {
            background-color: #f4f6f9;
        }

        .container {
            margin-top: 40px;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 50%; /* Logo redondeado */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            font-size: 1.1rem;
        }

        .table th {
            background-color: #003366;
            color: white;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f1f1f1;
        }

        .card {
            border: 0;
            border-radius: 10px;
        }

        .card-header {
            background-color: #003366;
            color: white;
            text-align: center;
        }

        .card-body {
            padding: 2rem;
        }

        .badge {
            font-size: 1rem;
        }

        .badge-success {
            background-color: #28a745; /* Verde para Activo */
        }

        .badge-danger {
            background-color: #dc3545; /* Rojo para Inactivo */
        }

        .table-hover tbody tr:hover {
            background-color: #dcdcdc;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script>
        document.getElementById('download-pdf').addEventListener('click', function () {
            document.getElementById('download-pdf').style.display = 'none';

            const options = {
                margin:       [0.5, 0.5, 0.5, 0.5],  // Ajuste de márgenes
                filename:     'reporte_empleados.pdf',
                image:        { type: 'jpeg', quality: 1.0 },
                html2canvas:  { dpi: 300, letterRendering: true, scale: 2 },  // Mayor escala
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait', autoFirstPage: true }
            };

            const element = document.querySelector('.content');  // Selecciona toda la sección

            html2pdf().from(element).set(options).save().then(function() {
                document.getElementById('download-pdf').style.display = 'block';
            });
        });
    </script>
@stop
