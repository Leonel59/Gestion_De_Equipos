@extends('adminlte::page')

@section('title', 'Reporte de Asignaciones')

@section('content')

<div class="row align-items-center">
    <div class="col-md-2 text-center">
        <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Empresa" class="img-fluid rounded-circle" style="max-width: 80px;">
    </div>
    <div class="col-md-10">
        <h1 class="font-weight-bold" style="font-size: 1.5rem; color: #003366; font-family: 'Arial', sans-serif;">Reporte de Asignaciones</h1>
        <p class="text-dark" style="font-size: 1rem; color: #003366; font-family: 'Roboto', sans-serif; letter-spacing: 1px;">
            Recarga Veloz
        </p>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-between">
        <div class="col-md-6 text-left">
            <p class="font-weight-bold" style="font-size: 0.9rem; color: #003366;">
                Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </p>
        </div>
        <div class="col-md-6 text-right">
            <p class="font-weight-bold" style="font-size: 0.9rem; color: #003366;">
                Dirección: Boulevard Suyapa, Tegucigalpa, Francisco Morazán
            </p>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <button id="download-pdf" class="btn btn-primary btn-sm">
                Descargar PDF
            </button>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header" style="background-color: #003366; color: white;">
                    <h3 class="card-title font-weight-bold mb-0" style="font-size: 1.2rem;">Asignaciones Registradas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm text-center" id="asignaciones-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Equipo</th>
                                    <th>Empleado</th>
                                    <th>Sucursal</th>
                                    <th>Área</th>
                                    <th>Detalles de Asignación</th>
                                    <th>Fecha de Asignación</th>
                                    <th>Fecha de Devolución</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asignaciones as $asignacion)
                                    <tr>
                                        <td>{{ $asignacion['equipo'] }}</td>
                                        <td>{{ $asignacion['empleado'] }}</td>
                                        <td>{{ $asignacion['sucursal'] }}</td>
                                        <td>{{ $asignacion['area'] }}</td>
                                        <td>{{ $asignacion['detalles_asignacion'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($asignacion['fecha_asignacion'])->format('d/m/Y ') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($asignacion['fecha_devolucion'])->format('d/m/Y ') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <style>
        .table {
            font-size: 0.8rem; /* Tamaño reducido */
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .card-header {
            background-color: #003366;
            color: white;
            text-align: center;
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
                filename:     'reporte_asignaciones.pdf',
                image:        { type: 'jpeg', quality: 0.98 },  // Alta calidad de imagen
                html2canvas:  { scale: 2, logging: true },  // Escala más alta para mejor resolución
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape', autoFirstPage: true }
            };

            const element = document.querySelector('.content');  // Selecciona toda la sección para el PDF

            // Aquí se hace la conversión a PDF
            html2pdf().from(element).set(options).save().then(function() {
                document.getElementById('download-pdf').style.display = 'block';
            });
        });
    </script>
@stop
