@extends('adminlte::page')

@section('title', 'Reporte de Proveedores')

@section('content')

<div class="row">
    <div class="col-md-0">
        <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Empresa" class="img-fluid rounded-circle" style="max-width: 120px;">
    </div>

    <div class="col-md-8">
        <h1 class="font-weight-bold" style="font-size: 1.8rem; color: #003366; font-family: 'Arial', sans-serif;">Reporte de Proveedores</h1>
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

    <!-- Tabla de Proveedores -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header" style="background-color: #003366; color: white;">
                    <h3 class="card-title font-weight-bold mb-0">Proveedores Registrados</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered table-sm" style="border-radius: 5px;" id="proveedores-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Proveedor</th>
                                <th>RTN</th>
                                <th>Contacto</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Departamento</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Tipo de Factura</th>
                                <th>Fecha de Facturación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proveedores as $proveedor)
                                <tr>
                                    <td>{{ $proveedor['nombre_proveedor'] }}</td>
                                    <td>{{ $proveedor['rtn_proveedor'] }}</td>
                                    <td>{{ $proveedor['contacto_proveedor'] }}</td>
                                    <td>{{ $proveedor['direccion_proveedor'] }}</td>
                                    <td>{{ $proveedor['ciudad_proveedor'] }}</td>
                                    <td>{{ $proveedor['departamento_proveedor'] }}</td>
                                    <td>{{ $proveedor['telefono_personal'] }}</td>
                                    <td>{{ $proveedor['correo_personal'] }}</td>
                                    <td>{{ $proveedor['tipo_factura'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($proveedor['fecha_facturacion'])->format('d/m/Y') }}</td>
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

.table {
    width: 100%; /* Asegura que la tabla ocupe todo el ancho del contenedor */
    table-layout: fixed; /* Fija el ancho de las columnas para evitar que se desborden */
    word-wrap: break-word; /* Ajuste de palabras largas en las celdas */
}

.table th, .table td {
    text-align: center;
    vertical-align: middle;
    font-size: 1rem;  /* Tamaño de fuente ajustado */
    padding: 0.5rem;  /* Espaciado de celdas */
    overflow: hidden;  /* Asegura que el texto largo no se desborde */
    word-wrap: break-word; /* Ajuste de texto largo */
}

.table th {
    background-color: #003366;
    color: white;
    padding: 1rem; /* Espaciado mayor para las celdas de encabezado */
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
    overflow-x: auto; /* Permite el desplazamiento horizontal si la tabla se desborda */
}

.table-hover tbody tr:hover {
    background-color: #dcdcdc;
}

@media (max-width: 768px) {
    .table {
        font-size: 0.9rem; /* Ajuste del tamaño de la fuente en pantallas más pequeñas */
    }

    .table th, .table td {
        padding: 0.3rem; /* Reducción de espacio en las celdas para pantallas pequeñas */
    }
}

/* Ajustes específicos para las columnas */
.table td:nth-child(1), .table th:nth-child(1) {
    width: 110px; /* Columna 'Proveedor' */
}

.table td:nth-child(2), .table th:nth-child(2) {
    width: 100px; /* Columna 'RTN' */
}

.table td:nth-child(3), .table th:nth-child(3) {
    width: 100px; /* Columna 'Contacto' */
}

.table td:nth-child(4), .table th:nth-child(4) {
    width: 100px; /* Columna 'Dirección' */
}

.table td:nth-child(5), .table th:nth-child(5) {
    width: 100px; /* Columna 'Teléfono' */
}

.table td:nth-child(6), .table th:nth-child(6) {
    width: 105px; /* Columna 'Email' */
}

.table td:nth-child(7), .table th:nth-child(7) {
    width: 100px; /* Columna 'Tipo de Factura' */
}

.table td:nth-child(8), .table th:nth-child(8) {
    width: 100px; /* Columna 'Fecha de Facturación' */
}



    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script>
        document.getElementById('download-pdf').addEventListener('click', function () {
            document.getElementById('download-pdf').style.display = 'none';

            const options = {
                margin:       0,
                filename:     'reporte_proveedores.pdf',
                image:        { type: 'jpeg', quality: 1.0 },
                html2canvas:  { dpi: 300, letterRendering: true, scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape', autoFirstPage: true }
            };

            const element = document.querySelector('.content');

            html2pdf().from(element).set(options).save().then(function() {
                document.getElementById('download-pdf').style.display = 'block';
            });
        });
    </script>
@stop

