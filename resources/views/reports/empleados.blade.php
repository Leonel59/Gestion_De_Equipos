@extends('adminlte::page')

@section('title', 'Reporte de Empleados')

@section('content')

<div class="row">
    <!-- Coloca el logo a la izquierda -->
    <div class="col-md-0">
        <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Empresa" class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
    </div>

    <div class="col-md-8">
            <h1 class="font-weight-bold, text-center" style="margin: 20px 0 0 40px; font-size: 1.8rem; color: #003366; font-family: 'Arial', sans-serif;">REPORTE DE EMPLEADOS</h1>
            <p class="text-dark" style="font-size: 1.2rem; color: #003366; font-family: 'Roboto', sans-serif; font-weight: 20; letter-spacing: 1px; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);">
                Recarga Veloz S.A. de C.V
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
        <div class="col-md-12">
            <button id="download-pdf" class="btn btn-primary" style="font-size: 1.2rem;">
                Descargar PDF
            </button>
        </div>
    </div>

    <!--Parte que añadi-->
        <!-- Sección de filtros y botones -->
        <div class="filter-container" id="filtrado">
            <div class="text-center">
                <button id="btnGenerarGraficoSucursal" class="btn btn-primary" style="font-size: 1.1rem;">Gráfico de Empleados Por Sucursal</button>
            </div>
            <div class="text-center">
                <button id="btnGenerarGraficoArea" class="btn btn-primary" style="font-size: 1.1rem;">Gráfico de Empleados Por Área</button>
            </div>
        </div>
    <!--Parte que añadi-->

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
                                <th>#</th>
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
                                    <td>{{ $empleado['cod_empleados'] }}</td>
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
                    <!--Parte añadida del total-->
                        <!-- Contenedor del empleados totales  -->
                        <div id="totalCosto-container" class="mt-3 text-right">
                            <h5><strong>Total de Empleados Registrados: </strong><span id="total-empleados">0</span></h5>
                        </div>
                        <!--Parte añadida del total-->
                        <!-- Parte del Gráfico -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <canvas id="myChart"></canvas>
                                <canvas id="empleadosPorAreaChart"></canvas>
                            </div>
                        </div>
                        <!-- Parte del Gráfico -->
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

        /*Parte que añadi al style*/
        .filter-container {
        margin-top: 20px;
        display: flex;
        flex-direction: row; /* Asegura que los elementos estén en fila */
        gap: 10px; /* Espacio entre los elementos */
        align-items: center;  /*Alinea los elementos verticalmente */
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>

    <script>
        document.getElementById('download-pdf').addEventListener('click', function () {
            document.getElementById('download-pdf').style.display = 'none';

            //PARTE QUE AÑADI
            // Seleccionar y ocultar la barra de filtrado
            const filterSection = document.querySelector('.dataTables_filter');
            if (filterSection) {
                filterSection.style.display = 'none';
            }

             // Seleccionar y ocultar la información de paginación y registros
            const paginationInfo = document.querySelector('.dataTables_info');
            if (paginationInfo) {
                paginationInfo.style.display = 'none';
            }

            const orderingSection = document.querySelector('.dataTables_sort');
            if (orderingSection) {
                orderingSection.style.display = 'none';
            }
            
            const lengthSection = document.querySelector('.dataTables_length')
            if (lengthSection) {
                lengthSection.style.display = 'none';
            }

            const paginationControls = document.querySelector('.dataTables_paginate');
            if (paginationControls) {
                paginationControls.style.display = 'none';
            }

            // Ocultar los elementos de filtrado (fecha desde, fecha hasta y botón filtrar)
            const filterInputs = document.querySelector('#filtrado');
            if (filterInputs) {
            filterInputs.style.display = 'none';
            }
            //AQUI TERMINA

            //Ajustes para la captura de los datos
            const options = {
                margin: [0.5, 0, 1.0, 0],  // Márgenes enteros
                filename:     'reporte_empleados.pdf', 
                image:        { type: 'jpg', quality: 1.0 },  //Calidad de la imagen 
                html2canvas:  { dpi: 500, letterRendering: true, scale: 2, scrollX: 0, scrollY: 0, useCORS: true},// Mayor escala para la captura
                jsPDF:        { unit: 'in', format: [12, 17], orientation: 'portrait', autoFirstPage: false } //format: aqui el ajuste lo hice por pulgadas para que sea personalizado [12, 17]
            };

            const element = document.querySelector('.content');  // Selecciona toda la sección

            //PARTE AÑADIDA
            //Sección de píe de página y número de página
            html2pdf()
                .from(element)
                .set(options)
                .toPdf()
                .get('pdf')
                .then((pdf) => {
                    const totalPages = pdf.internal.getNumberOfPages();
                    const pageWidth = pdf.internal.pageSize.getWidth();
                    const pageHeight = pdf.internal.pageSize.getHeight();

                    for (let i = 1; i <= totalPages; i++) {
                        pdf.setPage(i);
                        pdf.setFontSize(10);
                    
                    // Pie de página centrado (por encima de la numeración)
                    const footerText = 'Generado por Recarga Veloz S.A. de C.V.';
                    const footerX = pageWidth / 2; // Centro horizontal
                    const footerY = pageHeight - 0.7; // Ajusta la altura del pie de página (más arriba que la numeración)
                    pdf.text(footerText, footerX, footerY, { align: 'center' });
                    
                    // Numeración de página centrada
                    const pageNumberText = `Página ${i} de ${totalPages}`;
                    const pageNumberX = pageWidth / 2; // Centro horizontal
                    const pageNumberY = pageHeight - 0.5; // Más abajo que el pie de página
                    pdf.text(pageNumberText, pageNumberX, pageNumberY, { align: 'center' });
                    }
                })
                .save()
                .finally(() => {
            //AQUI TERMINA 

                //Vuelve a mostrar el botón de Descargar PDF (Modifique la línea de código)
                document.getElementById('download-pdf').style.display = 'block';
            
                // PARTE QUE AÑADI
                // Volver a mostrar la sección de filtrado después de la descarga
                if (filterSection) filterSection.style.display = 'block';
                if (paginationInfo) paginationInfo.style.display = 'block';
                if (orderingSection) orderingSection.style.display = 'block';
                if (lengthSection) lengthSection.style.display = 'block';
                if (paginationControls) paginationControls.style.display = 'block';
                if (filterInputs) filterInputs.style.display = 'flex';
                //AQUI TERMINA
            });
        });
    </script>

    <!-- Parte que agregue para el filtrado -->
    <script>
    $(document).ready(function () {
        // Inicializar DataTable
        var table = $('#empleados-table').DataTable({
            language: {
                search: "Filtrado Específico:",
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                paginate: { previous: "Anterior", next: "Siguiente" }
            },
            //Filtrado personalizado 
            lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]], // Opciones de registros por página
        });


        // Forzar que todos los datos filtrados para que se muestren en una sola página
        table.page.len(-1).draw();

        // Luego actualiza el gráfico
    });
    </script>

    <script>
        document.getElementById("btnGenerarGraficoSucursal").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#empleados-table tbody tr");
    const sucursalCounts = {};

    rows.forEach(row => {
        const sucursal = row.querySelectorAll("td")[1].innerText; // Nombre de la sucursal
        if (!sucursalCounts[sucursal]) {
            sucursalCounts[sucursal] = 0;
        }
        sucursalCounts[sucursal]++;
    });

    // Extrae etiquetas y valores para el gráfico
    const labels = Object.keys(sucursalCounts);
    const data = Object.values(sucursalCounts);

    // Verifica si ya existe un gráfico previo y elimínalo para evitar conflictos
    if (window.myChartInstance) {
        window.myChartInstance.destroy();
    }

    // Crea el gráfico
    const ctx = document.getElementById("myChart").getContext("2d");
    window.myChartInstance = new Chart(ctx, {
        type: "bar", // Gráfico de barras
        data: {
            labels: labels,
            datasets: [{
                label: "Cantidad de Empleados Por Sucursal",
                data: data,
                backgroundColor: "rgba(0, 123, 255, 0.5)",
                borderColor: "rgba(0, 123, 255, 1)", // Verde oscuro
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Sucursales",
                        color: "#003366",
                        font: {
                            size: 14,
                            weight: "bold"
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Cantidad de Empleados",
                        color: "#003366",
                        font: {
                            size: 14,
                            weight: "bold"
                        }
                    },
                    ticks: {
            stepSize: 1 // Asegura que las marcas del eje Y sean números enteros
        }
                }
            }
        }
    });
});
    </script>

<script>
        document.getElementById("btnGenerarGraficoArea").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#empleados-table tbody tr");
    const areasCounts = {};

    rows.forEach(row => {
        const areas = row.querySelectorAll("td")[2].innerText; // Nombre de la sucursal
        if (!areasCounts[areas]) {
            areasCounts[areas] = 0;
        }
        areasCounts[areas]++;
    });

    // Extrae etiquetas y valores para el gráfico
    const labels = Object.keys(areasCounts);
    const data = Object.values(areasCounts);

    // Verifica si ya existe un gráfico previo y elimínalo para evitar conflictos
    if (window.myChartInstance) {
        window.myChartInstance.destroy();
    }

    // Crea el gráfico
    const ctx = document.getElementById("myChart").getContext("2d");
    window.myChartInstance = new Chart(ctx, {
        type: "bar", // Gráfico de barras
        data: {
            labels: labels,
            datasets: [{
                label: "Cantidad de Empleados Por Área",
                data: data,
                backgroundColor: "rgba(0, 123, 255, 0.5)",
                borderColor: "rgba(0, 123, 255, 1)", 
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Áreas",
                        color: "#003366",
                        font: {
                            size: 14,
                            weight: "bold"
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Cantidad de Empleados",
                        color: "#003366",
                        font: {
                            size: 14,
                            weight: "bold"
                        }
                    }, 
                    ticks: {
            stepSize: 1 // Asegura que las marcas del eje Y sean números enteros
        }
                }
            }
        }
    });
});
    </script>

    <script>
    // Obtener el contexto del canvas
    const ctx2 = document.getElementById('btnGenerarGraficoArea').getContext('2d');

    // Datos del gráfico (ejemplo)
    const areas = ['Administración', 'Ventas', 'Producción', 'Recursos Humanos']; // Eje X
    const empleadosPorArea = [15, 30, 45, 10]; // Eje Y

    // Crear el gráfico
    const empleadosPorAreaChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: areas, // Etiquetas para el eje X
            datasets: [{
                label: 'Cantidad de empleados por área',
                data: empleadosPorArea, // Datos para el eje Y
                backgroundColor: [
                    'rgba(75, 192, 192, 0.5)', // Verde
                    'rgba(255, 99, 132, 0.5)', // Rojo
                    'rgba(54, 162, 235, 0.5)', // Azul
                    'rgba(255, 206, 86, 0.5)'  // Amarillo
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)', 
                    'rgba(255, 99, 132, 1)', 
                    'rgba(54, 162, 235, 1)', 
                    'rgba(255, 206, 86, 1)'  
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true, // Comenzar el eje Y en 0
                    title: {
                        display: true,
                        text: 'Cantidad de Empleados'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Áreas de la Empresa'
                    }
                }
            }
        }
    });
    </script>

    <script>
    // Función para calcular el total de empleados registrados
    function calcularTotalEmpleados() {
        // Contar el número de filas en el cuerpo de la tabla
        const totalEmpleados = document.querySelectorAll('#empleados-table tbody tr').length;

        // Actualizar el contenedor del total
        document.getElementById('total-empleados').textContent = totalEmpleados;
    }

    // Ejecutar la función cuando la página haya cargado
    document.addEventListener('DOMContentLoaded', calcularTotalEmpleados);
    </script>
@stop

