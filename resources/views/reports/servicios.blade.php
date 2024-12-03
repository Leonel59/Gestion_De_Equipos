@extends('adminlte::page')

@section('title', 'Reporte de Servicios de Mantenimiento')

@section('content')

<div class="row align-items-center">
    <!-- Coloca el logo a la izquierda -->
    <div class="col-md-0">
            <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Recarga Veloz S.A. de C.V." class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
        </div>
        <div class="col-md-8">
            <h1 class="font-weight-bold, text-center" style="margin: 20px 0 0 40px; font-size: 1.8rem; color: #003366; font-family: 'Arial', sans-serif;">REPORTE DE MANTENIMIENTOS</h1>
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
        <!-- Filtros de Fecha Desde y Fecha Hasta -->
        <div class="filter-container" id="filtrado">
            <div class="text-center">
                <button id="btnGenerarGraficoMantenimientos" class="btn btn-primary" style="font-size: 1.1rem;">Ver Gráfico de Mantenimientos</button>
            </div>
        </div>
        <!--Parte que añadi-->

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header" style="background-color: #003366; color: white;">
                    <h3 class="card-title font-weight-bold mb-0" style="font-size: 1.2rem;">Servicios de Mantenimiento Registrados</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm text-center" id="servicios-table">
                            <thead class="thead-dark">
                                <tr>
                                    <!--<th>ID Mant.</th>-->
                                    <th>ID Equipo</th>
                                    <th>Tipo Mantenimiento</th>
                                    <th>Descripción</th>
                                    <th>Cant. Usada</th>
                                    <th>Duración (Horas)</th>
                                    <th>Fecha Reparación</th>
                                    <th>Fecha Entrega</th>
                                    <th>Costo Mant. (Lps)</th>
                                    <th>Producto</th>
                                    <th>Cant. Producto</th>
                                    <th>Costo Prod. (Lps)</th>
                                    <th>Total (Lps)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicios as $servicio)
                                    @php
                                        $costo_mantenimiento = $servicio['costo_mantenimiento'];
                                        $costo_producto = $servicio['costo_producto'] ?? 0;
                                        $total = $costo_mantenimiento + $costo_producto;
                                    @endphp
                                    <tr>
                                        <!--<td>{{ $servicio['id_mant'] }}</td>-->
                                        <td>{{ $servicio['id_equipo_mant'] }}</td>
                                        <td>{{ $servicio['tipo_mantenimiento'] }}</td>
                                        <td>{{ $servicio['descripcion_mantenimiento'] }}</td>
                                        <td>{{ $servicio['cantidad_equipo_usado'] ?? 'N/A' }}</td>
                                        <td>{{ $servicio['duracion_mantenimiento'] ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($servicio['fecha_reparacion_equipo'])->format('d/m/Y ') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($servicio['fecha_entrega_equipo'])->format('d/m/Y ') }}</td>
                                        <td>L.{{ number_format($costo_mantenimiento, 2) }}</td>
                                        <td>{{ $servicio['nombre_producto'] ?? 'N/A' }}</td>
                                        <td>{{ $servicio['cantidad_producto'] ?? 'N/A' }}</td>
                                        <td>L.{{ number_format($costo_producto, 2) }}</td>
                                        <td><strong>{{ number_format($total, 2) }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--Parte añadida del total-->
                        <!-- Contenedor del costo total de los Mantenimientos  -->
                        <div id="totalMantenimientos-container" class="mt-3 text-right">
                            <h5><strong>Costo Total de Mantenimientos:</strong> L.<span id="total-Mant">0,00</span></h5>
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

        .table {
            font-size: 0.8rem; /* Tamaño reducido */
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #003366;
            color: white;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 50%; /* Logo redondeado */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
                filename:     'reporte_servicios.pdf', 
                image:        { type: 'jpg', quality: 1.0 },  //Calidad de la imagen 
                html2canvas:  { dpi: 500, letterRendering: true, scale: 2, scrollX: 0, scrollY: 0, useCORS: true},// Mayor escala para la captura
                jsPDF:        { unit: 'in', format: [12, 17], orientation: 'portrait', autoFirstPage: false } //format: aqui el ajuste lo hice por pulgadas para que sea personalizado [12, 17]
            };

             // Selecciona la sección que se quiere exportar a PDF
            const element = document.querySelector('.content');  // Selecciona toda la sección para el PDF
            
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

                // Aquí se hace la conversión a PDF
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
        var table = $('#servicios-table').DataTable({
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

    <!-- Script de los Gráficos -->
    <script>
    document.getElementById("btnGenerarGraficoMantenimientos").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#servicios-table tbody tr");
    const labels = []; // Etiquetas del gráfico (Código Equipo y Fecha)
    const data = []; // Datos del gráfico (Costos)
    let totalCosto = 0; // Variable para acumular el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const codigoEquipo = cells[0].innerText; // Código del equipo
        const fechaMantenimiento = cells[5].innerText; // Fecha del mantenimiento
        const costo = parseFloat(cells[11].innerText.replace("L.", "").replace(",", "")); // Costo del mantenimiento

        labels.push(`${codigoEquipo} (${fechaMantenimiento})`);
        data.push(costo);
        totalCosto += costo; // Sumar al costo total
    });

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
                label: "Costo Total de Mantenimientos (Lempiras)",
                data: data,
                backgroundColor: "rgba(0, 123, 255, 0.5)",
                borderColor: "rgba(0, 123, 255, 1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `L. ${context.raw.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: "top"
                },
                annotation: {
                    annotations: {
                        costoTotal: {
                            type: 'label',
                            content: `Costo Total de los Mantenimientos Mostrados: L.${totalCosto.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`,
                            position: {
                                x: 'end', // Posición final del eje X
                                y: 'start' // Posición inicial del eje Y
                            },
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 1,
                            padding: 5,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return `L. ${value.toLocaleString("es-HN")}`;
                        }
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
    infoContainer.innerHTML = `<strong>Costo Total de los Mantenimientos:</strong> L. ${totalCosto.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`;
});
</script>

<script>
    // Función para calcular el total del costo de los equipos
    function calcularTotalMantenimiento() {
        let total = 0;

        // Iterar sobre todas las filas de la tabla en la columna de costos
        document.querySelectorAll('#servicios-table tbody tr').forEach(row => {
            const costo = parseFloat(row.cells[11].textContent.replace('L.', '').replace(',', '').trim()) || 0; // Columna del Total
            total += costo;
        });

        // Actualizar el contenedor del total
        document.getElementById('total-Mant').textContent = total.toLocaleString('es-HN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Ejecutar la función cuando la página haya cargado
    document.addEventListener('DOMContentLoaded', calcularTotalMantenimiento);
</script>
    <!-- Fin -->
@stop






