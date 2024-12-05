@extends('adminlte::page')

@section('title', 'Reporte de Asignaciones')

@section('content')

<div class="row">
<!-- Coloca el logo a la izquierda -->
<div class="col-md-0">
            <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Recarga Veloz S.A. de C.V." class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
        </div>

<div class="col-md-8">
            <h1 class="font-weight-bold, text-center" style="margin: 20px 0 0 40px; font-size: 1.8rem; color: #003366; font-family: 'Arial', sans-serif;">REPORTE DE ASIGNACIONES</h1>
            <p class="text-dark" style="font-size: 1.2rem; color: #003366; font-family: 'Roboto', sans-serif; font-weight: 20; letter-spacing: 1px; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);">
                Recarga Veloz S.A. de C.V
            </p>
        </div>
    </div>

<div class="container mt-4">
    <div class="row justify-content-between">
        <div class="col-md-6 text-left">
            <p class="font-weight-bold" style="font-size: 1.0rem; color: #003366;">
                Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </p>
        </div>
        <div class="col-md-6 text-right">
            <p class="font-weight-bold" style="font-size: 1.0rem; color: #003366;">
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
    <!-- Filtros de Fecha Desde y Fecha Hasta -->
    <div class="filter-container" id="filtrado">
        <div class="text-center">
            <button id="btnGenerarGraficoAsignacionesSucursal" class="btn btn-primary" style="font-size: 1.0rem;">Gráfico de Asignaciones Por Sucursal</button>
        </div>
        <div class="text-center">
            <button id="btnGenerarGraficoAsignacionesArea" class="btn btn-primary" style="font-size: 1.0rem;">Gráfico de Asignaciones Por Área</button>
        </div>
    </div>
    <!--Parte que añadi-->

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
                                    <th>Suministro Asignado</th>
                                    <th>Costo Equipo</th>
                                    <th>Costo Suministros</th>
                                    <th>Fecha de Asignación</th>
                                    <th>Fecha de Devolución</th>
                                    <th>Costo Equipo Asignado</th>
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
                                        <td>{{ $asignacion['suministros']}}</td>
                                        <td>L.{{ number_format($asignacion['precio_equipo'], 2) }}</td>
                                        <td>L.{{ number_format($asignacion['costo_suministros'], 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($asignacion['fecha_asignacion'])->format('d/m/Y ') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($asignacion['fecha_devolucion'])->format('d/m/Y ') }}</td>
                                        <td>L.{{ number_format($asignacion['costo_total_asignado'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--Parte añadida del total de Equipos asignados-->
                        <!-- Contenedor del costo total,  -->
                        <div id="totalAsignados-container" class="mt-3 text-right">
                            <h5><strong>Equipos Asignados:</strong> <span id="total-asignado">0</span></h5>
                        </div>
                        <!--Parte añadida del total-->

                        <!-- Parte del Gráfico -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                        <!-- Parte del Gráfico -->
                    </div>
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
            font-size: 0.8rem; /* Tamaño reducido */
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            font-size: 0.8rem;
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

        /*Parte que añadi al style*/
        .filter-container {
        margin-top: 20px;
        display: flex;
        flex-direction: row; /* Asegura que los elementos estén en fila */
        gap: 10px; /* Espacio entre los elementos */
        align-items: center; /* Alinea los elementos verticalmente */
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
                margin: [0.5, 0, 1.0, 0],  // Ajuste de márgenes
                filename:     'reporte_asignaciones.pdf', 
                image:        { type: 'jpg', quality: 1.0 },  //Calidad de la imagen 
                html2canvas:  { dpi: 500, letterRendering: true, scale: 2, scrollX: 0, scrollY: 0, useCORS: true},// Mayor escala para la captura
                jsPDF:        { unit: 'in', format: [12, 17], orientation: 'portrait', autoFirstPage: false } //format: aqui el ajuste lo hice por pulgadas para que sea personalizado [12, 17]
            };

            // Selecciona la sección que se quiere exportar a PDF
            const element = document.querySelector('.content'); 

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
        var table = $('#asignaciones-table').DataTable({
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
    });
    </script>

    <!-- Script Del Gráfico -->
    <script>
    document.getElementById("btnGenerarGraficoAsignacionesSucursal").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#asignaciones-table tbody tr");
    const sucursales = {}; // Objeto para almacenar las asignaciones por sucursal
    let totalCostoEquipos = 0; // Variable para calcular el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const sucursal = cells[2].innerText; // Nombre de la sucursal
        const costoEquipo = parseFloat(cells[10].innerText.replace("L.", "").replace(",", "")); // Costo del equipo asignado

        // Incrementar el contador de asignaciones por sucursal
        if (!sucursales[sucursal]) {
            sucursales[sucursal] = { count: 0, totalCosto: 0 };
        }
        sucursales[sucursal].count++;
        sucursales[sucursal].totalCosto += costoEquipo;

        // Calcular el costo total de los equipos
        totalCostoEquipos += costoEquipo;
    });

    // Extraer los datos para el gráfico
    const labels = Object.keys(sucursales);
    const dataCounts = labels.map(sucursal => sucursales[sucursal].count);
    const dataCostos = labels.map(sucursal => sucursales[sucursal].totalCosto);

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
            datasets: [
                {
                    label: "Asignaciones Por Sucursal",
                    data: dataCounts,
                    backgroundColor: "rgba(75, 192, 192, 0.5)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                    yAxisID: "yAxisCount" // Vincula con un eje Y específico
                },
                {
                    label: "Costo Total de los Equipos Asignados Por Sucursal (Lempiras)",
                    data: dataCostos,
                    type: "line", // Añadido como línea para superponer al gráfico de barras
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 2,
                    fill: false,
                    yAxisID: "yAxisCost" // Vincula con otro eje Y específico
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            if (context.dataset.label === "Costo Total de los Equipos Asignados Por Sucursal (Lempiras)") {
                                return `L. ${context.raw.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
                            } else {
                                return context.raw; // Solo devuelve el número para las asignaciones
                            }
                        }
                    }
                },
                legend: {
                    display: true,
                    position: "top"
                },
                annotation: {
                    annotations: {
                        totalAnnotation: {
                            type: 'label',
                            content: [
                                `Costo Total de las Asignaciones Mostradas: L. ${totalCostoEquipos.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`,
                                `Asignaciones Mostradas: ${rows.length}`
                            ],
                            position: 'bottom', // Posición en la parte inferior del gráfico
                            yValue: 0, // Ancla la anotación al valor 0 en el eje Y
                            yAdjust: -30, // Desplaza la anotación 30 píxeles hacia abajo desde el punto anclado
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            color: '#fff',
                            padding: 10,
                            borderRadius: 5
                        }
                    }
                }
            },
            scales: {
                yAxisCount: {
                    type: "linear",
                    position: "left",
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return value % 1 === 0 ? value : ""; // Muestra solo enteros
                        }
                    },
                    title: {
                        display: true,
                        text: "Cantidad de Asignaciones"
                    }
                },
                yAxisCost: {
                    type: "linear",
                    position: "right",
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return `L. ${value.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
                        }
                    },
                    title: {
                        display: true,
                        text: "Costo Total (Lempiras)"
                    },
                    grid: {
                        drawOnChartArea: false // Evita superposición de líneas del grid
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            }
        }
    });

    // Agregar una viñeta debajo del gráfico con el costo total (manteniendo el anterior)
    const chartContainer = document.getElementById("chartContainer");
    let infoContainer = document.getElementById("infoContainer");
    if (!infoContainer) {
        infoContainer = document.createElement("div");
        infoContainer.id = "infoContainer";
        infoContainer.style.marginTop = "10px";
        infoContainer.style.padding = "10px";
        infoContainer.style.border = "1px solid #ddd";
        infoContainer.style.borderRadius = "5px";
        infoContainer.style.backgroundColor = "#f9f9f9";
        infoContainer.style.fontSize = "14px";
        infoContainer.style.textAlign = "center";
        chartContainer.appendChild(infoContainer);
    }
    infoContainer.innerHTML = `<strong>Costo Total de los Equipos Asignados:</strong> L. ${totalCostoEquipos.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
});
    </script>

    <script>
    document.getElementById("btnGenerarGraficoAsignacionesSucursal").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#asignaciones-table tbody tr");
    const sucursales = {}; // Objeto para almacenar las asignaciones por sucursal
    let totalCostoEquipos = 0; // Variable para calcular el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const sucursal = cells[2].innerText; // Nombre de la sucursal
        const costoEquipo = parseFloat(cells[10].innerText.replace("L.", "").replace(",", "")); // Costo del equipo asignado

        // Incrementar el contador de asignaciones por sucursal
        if (!sucursales[sucursal]) {
            sucursales[sucursal] = { count: 0, totalCosto: 0 };
        }
        sucursales[sucursal].count++;
        sucursales[sucursal].totalCosto += costoEquipo;

        // Calcular el costo total de los equipos
        totalCostoEquipos += costoEquipo;
    });

    // Extraer los datos para el gráfico
    const labels = Object.keys(sucursales);
    const dataCounts = labels.map(sucursal => sucursales[sucursal].count);
    const dataCostos = labels.map(sucursal => sucursales[sucursal].totalCosto);

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
            datasets: [
                {
                    label: "Asignaciones Por Sucursal",
                    data: dataCounts,
                    backgroundColor: "rgba(75, 192, 192, 0.5)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                    yAxisID: "yAxisCount" // Vincula con un eje Y específico
                },
                {
                    label: "Costo Total de los Equipos Asignados Por Sucursal (Lempiras)",
                    data: dataCostos,
                    type: "line", // Añadido como línea para superponer al gráfico de barras
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 2,
                    fill: false,
                    yAxisID: "yAxisCost" // Vincula con otro eje Y específico
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            if (context.dataset.label === "Costo Total de los Equipos Asignados Por Sucursal (Lempiras)") {
                                return `L. ${context.raw.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
                            } else {
                                return context.raw; // Solo devuelve el número para las asignaciones
                            }
                        }
                    }
                },
                legend: {
                    display: true,
                    position: "top"
                },
                annotation: {
                    annotations: {
                        totalAnnotation: {
                            type: 'label',
                            content: [
                                `Costo Total de las Asignaciones Mostradas: L. ${totalCostoEquipos.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`,
                                `Asignaciones Mostradas: ${rows.length}`
                            ],
                            position: 'bottom', // Posición en la parte inferior del gráfico
                            yValue: 0, // Ancla la anotación al valor 0 en el eje Y
                            yAdjust: -30, // Desplaza la anotación 30 píxeles hacia abajo desde el punto anclado
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            color: '#fff',
                            padding: 10,
                            borderRadius: 5
                        }
                    }
                }
            },
            scales: {
                yAxisCount: {
                    type: "linear",
                    position: "left",
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return value % 1 === 0 ? value : ""; // Muestra solo enteros
                        }
                    },
                    title: {
                        display: true,
                        text: "Cantidad de Asignaciones"
                    }
                },
                yAxisCost: {
                    type: "linear",
                    position: "right",
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return `L. ${value.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
                        }
                    },
                    title: {
                        display: true,
                        text: "Costo Total (Lempiras)"
                    },
                    grid: {
                        drawOnChartArea: false // Evita superposición de líneas del grid
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            }
        }
    });

    // Agregar una viñeta debajo del gráfico con el costo total (manteniendo el anterior)
    const chartContainer = document.getElementById("chartContainer");
    let infoContainer = document.getElementById("infoContainer");
    if (!infoContainer) {
        infoContainer = document.createElement("div");
        infoContainer.id = "infoContainer";
        infoContainer.style.marginTop = "10px";
        infoContainer.style.padding = "10px";
        infoContainer.style.border = "1px solid #ddd";
        infoContainer.style.borderRadius = "5px";
        infoContainer.style.backgroundColor = "#f9f9f9";
        infoContainer.style.fontSize = "14px";
        infoContainer.style.textAlign = "center";
        chartContainer.appendChild(infoContainer);
    }
    infoContainer.innerHTML = `<strong>Costo Total de los Equipos Asignados:</strong> L. ${totalCostoEquipos.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
});
    </script>

    <!-- Escript del Grafico por Area-->
    <script>
    document.getElementById("btnGenerarGraficoAsignacionesArea").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#asignaciones-table tbody tr");
    const areas = {}; // Objeto para almacenar las asignaciones por área
    let totalCostoEquipos = 0; // Variable para calcular el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const area = cells[3].innerText; // Cambia al índice correcto para obtener el área
        const costoEquipo = parseFloat(cells[10].innerText.replace("L.", "").replace(",", "")); // Costo del equipo asignado

        // Incrementar el contador de asignaciones por área
        if (!areas[area]) {
            areas[area] = { count: 0, totalCosto: 0 };
        }
        areas[area].count++;
        areas[area].totalCosto += costoEquipo;

        // Calcular el costo total de los equipos
        totalCostoEquipos += costoEquipo;
    });

    // Extraer los datos para el gráfico
    const labels = Object.keys(areas);
    const dataCounts = labels.map(area => areas[area].count);
    const dataCostos = labels.map(area => areas[area].totalCosto);

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
            datasets: [
                {
                    label: "Asignaciones Por Área",
                    data: dataCounts,
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                    yAxisID: "yAxisCount" // Vincula con un eje Y específico
                },
                {
                    label: "Costo Total de los Equipos Asignados Por Área (Lempiras)",
                    data: dataCostos,
                    type: "line", // Añadido como línea para superponer al gráfico de barras
                    backgroundColor: "rgba(153, 102, 255, 0.5)",
                    borderColor: "rgba(153, 102, 255, 1)",
                    borderWidth: 2,
                    fill: false,
                    yAxisID: "yAxisCost" // Vincula con otro eje Y específico
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            if (context.dataset.label === "Costo Total de los Equipos Asignados Por Área (Lempiras)") {
                                return `L. ${context.raw.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
                            } else {
                                return context.raw; // Solo devuelve el número para las asignaciones
                            }
                        }
                    }
                },
                legend: {
                    display: true,
                    position: "top"
                },
                annotation: {
                    annotations: {
                        totalAnnotation: {
                            type: 'label',
                            content: [
                                `Costo Total de las Asignaciones Mostradas: L. ${totalCostoEquipos.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`,
                                `Asignaciones Mostradas: ${rows.length}`
                            ],
                            position: 'bottom', // Posición en la parte inferior del gráfico
                            yValue: 0, // Ancla la anotación al valor 0 en el eje Y
                            yAdjust: -30, // Desplaza la anotación 30 píxeles hacia abajo desde el punto anclado
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            color: '#fff',
                            padding: 10,
                            borderRadius: 5
                        }
                    }
                }
            },
            scales: {
                yAxisCount: {
                    type: "linear",
                    position: "left",
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return value % 1 === 0 ? value : ""; // Muestra solo enteros
                        }
                    },
                    title: {
                        display: true,
                        text: "Cantidad de Asignaciones"
                    }
                },
                yAxisCost: {
                    type: "linear",
                    position: "right",
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return `L. ${value.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
                        }
                    },
                    title: {
                        display: true,
                        text: "Costo Total (Lempiras)"
                    },
                    grid: {
                        drawOnChartArea: false // Evita superposición de líneas del grid
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            }
        }
    });

    // Agregar una viñeta debajo del gráfico con el costo total
    const chartContainer = document.getElementById("chartContainer");
    let infoContainer = document.getElementById("infoContainer");
    if (!infoContainer) {
        infoContainer = document.createElement("div");
        infoContainer.id = "infoContainer";
        infoContainer.style.marginTop = "10px";
        infoContainer.style.padding = "10px";
        infoContainer.style.border = "1px solid #ddd";
        infoContainer.style.borderRadius = "5px";
        infoContainer.style.backgroundColor = "#f9f9f9";
        infoContainer.style.fontSize = "14px";
        infoContainer.style.textAlign = "center";
        chartContainer.appendChild(infoContainer);
    }
    infoContainer.innerHTML = `<strong>Costo Total de los Equipos Asignados:</strong> L. ${totalCostoEquipos.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
});
    </script>

    <!-- Script para calcular el total de equipos que se han asignado-->
    <script>
        // Función para contar la cantidad de equipos asignados
        function totalEquiposAsignados() {
            // Contar la cantidad de filas en el tbody de la tabla
            const cantidad = document.querySelectorAll('#asignaciones-table tbody tr').length;

            // Actualizar el valor en el contenedor correspondiente
            document.getElementById('total-asignado').textContent = cantidad;
        }

        // Ejecutar la función después de que la página haya cargado
        document.addEventListener('DOMContentLoaded', totalEquiposAsignados);
    </script>
@stop
