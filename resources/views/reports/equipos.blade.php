@extends('adminlte::page')

@section('title', 'Reporte de Equipos')


@section('content')

<div class="row">
        <!-- Coloca el logo a la izquierda -->
        <div class="col-md-0">
            <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Recarga Veloz S.A. de C.V." class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
        </div>

<div class="col-md-8">
            <h1 class="font-weight-bold, text-center" style="margin: 20px 0 0 40px; font-size: 1.8rem; color: #003366; font-family: 'Arial', sans-serif;">REPORTE DE EQUIPOS</h1>
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
            <div class="col-md-3">
                <label for="fecha_desde" class="font-weight-bold">Fecha Desde:</label>
                <input type="date" id="fecha_desde" class="form-control" style="font-size: 1.1rem;">
            </div>
            <div class="col-md-3">
                <label for="fecha_hasta" class="font-weight-bold">Fecha Hasta:</label>
                <input type="date" id="fecha_hasta" class="form-control" style="font-size: 1.1rem;">
            </div>
            <div class="col-md-3 align-self-end">
                <button id="filtrar-fechas" class="btn btn-success" style="font-size: 1.1rem;">Filtrar por fecha</button>
            </div>
            <div class="col-md-3 align-self-end">
                <button id="btnGenerarGrafico" class="btn btn-primary" style="font-size: 1.1rem;">Ver Gráfico de Costo</button>
            </div>
        </div>
        <!--Parte que añadi-->

        <!-- Tabla de Equipos -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header" style="background-color: #003366; color: white;">
                        <h3 class="card-title font-weight-bold mb-0">Equipos Registrados</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered table-sm"  style="border-radius: 5px;" id="equipos-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Tipo Equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Estado</th>
                                    <th>Número Serie</th>
                                    <th>Costo</th>
                                    <th>Depreciación</th>
                                    <th>Fecha Adquisición</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipos as $equipo)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $equipo['cod_equipo'] }}</td>
                                        <td>{{ $equipo['tipo_equipo'] }}</td>
                                        <td>{{ $equipo['marca_equipo'] }}</td>
                                        <td>{{ $equipo['modelo_equipo'] }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($equipo['estado_equipo'] == 'Disponible') badge-success 
                                                @elseif($equipo['estado_equipo'] == 'En Mantenimiento') badge-warning 
                                                @elseif($equipo['estado_equipo'] == 'Comodin') badge-primary
                                                @elseif($equipo['estado_equipo'] == 'Asignado') badge-info
                                                @endif">
                                                {{ $equipo['estado_equipo'] }}
                                            </span>
                                        </td>
                                        <td>{{ $equipo['numero_serie'] }}</td>
                                        <td>L.{{ number_format($equipo['precio_equipo'], 2) }}</td>
                                        <td>{{ $equipo['depreciacion_equipo'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($equipo['fecha_adquisicion'])->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--Parte añadida del total-->
                        <!-- Contenedor del costo total,  -->
                        <div id="totalCosto-container" class="mt-3 text-right">
                            <h5><strong>Costo del Inventario Total:</strong> L.<span id="total-cost">0,00</span></h5>
                        </div>
                        <div id="depreciacion-container" class="mt-3 text-right">
                            <h5><strong>Depreciación Total:</strong> L.<span id="depreciacion">0,00</span></h5>
                        </div>
                        <div id="totalNeto-container" class="mt-3 text-right">
                            <h5><strong>Valor Neto del Inventario:</strong> L.<span id="valor-neto">0,00</span></h5>
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
            font-size: 1.0rem;
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
            background-color: #28a745; /* Verde para Disponible */
        }

        .badge-warning {
            background-color: #ffc107; /* Naranja para En Mantenimiento */
        }

        .badge-danger {
            background-color: #dc3545; /* Rojo para No Disponible */
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
                filename:     'reporte_equipos.pdf', 
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
        var table = $('#equipos-table').DataTable({
            language: {
                search: "Filtrado Específico:",
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                paginate: { previous: "Anterior", next: "Siguiente" }
            }
        });
    
    $('#filtrar-fechas').on('click', function () {
        var fechaDesde = $('#fecha_desde').val();
        var fechaHasta = $('#fecha_hasta').val();

        // Validar que las fechas no estén vacías
        if (!fechaDesde || !fechaHasta) {
            alert('Por favor, selecciona ambas fechas para aplicar el filtro.');
            return;
        }

        // Convertir fechas a objetos Date para comparaciones
        var desde = new Date(fechaDesde);
        var hasta = new Date(fechaHasta);

        // Obtener todas las filas del DataTable
        table.rows().every(function () {
        var rowData = this.data();
        var fechaAdquisicion = rowData[9]; // Columna de Fecha de Adquisición

        // Convertir la fecha de la tabla a un objeto Date
        var fechaTabla = new Date(fechaAdquisicion.split('/').reverse().join('-'));

        if (fechaTabla >= desde && fechaTabla <= hasta) {
            $(this.node()).show(); // Mostrar la fila si está en el rango
        } else {
            $(this.node()).hide(); // Ocultar la fila si no está en el rango
        }
    });

        // Forzar que todos los datos filtrados para que se muestren en una sola página
        table.page.len(-1).draw();

        // Luego actualiza el gráfico
        });
    });
    </script>
    
    <!-- Script del Gráfico -->
    <script>
    document.getElementById("btnGenerarGrafico").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#equipos-table tbody tr");
    const labels = []; // Para las fechas de adquisición
    const data = []; // Para los precios
    let totalCosto = 0; // Variable para el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const fechaAdquisicion = cells[9].innerText; // Fecha de adquisición
        const precio = parseFloat(cells[7].innerText.replace("L.", "").replace(",", "")); // Precio del equipo

        // Convertir la fecha a formato Date para el gráfico
        const fecha = new Date(fechaAdquisicion.split('/').reverse().join('-')).getTime();

        // Agregar los datos al gráfico
        labels.push(fecha);
        data.push(precio);
        totalCosto += precio; // Sumar al costo total
    });

    // Verifica si ya existe un gráfico previo y elimínalo para evitar conflictos
    if (window.myChartInstance) {
        window.myChartInstance.destroy();
    }

    // Crea el gráfico
    const ctx = document.getElementById("myChart").getContext("2d");
    window.myChartInstance = new Chart(ctx, {
        type: "scatter", // Cambiado a gráfico de líneas
        data: {
            labels: labels,
            datasets: [{
                label: "Costo de Equipos (Lempiras)",
                data: data,
                backgroundColor: "rgba(0, 123, 255, 0.5)",
                borderColor: "rgba(0, 123, 255, 1)",
                borderWidth: 2,
                pointBackgroundColor: "rgba(0, 123, 255, 1)",
                pointBorderColor: "#fff",
                pointBorderWidth: 2,
                pointRadius: 5,
                fill: false // No llenar el área bajo la línea
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    ticks: {
                        callback: function(value, index, values) {
                            const date = new Date(value);
                            return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`; // Formato de fecha
                        }
                    },
                    title: {
                        display: true,
                        text: 'Fecha de Adquisición de los Equipos'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Costo (Lempiras)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const code = document.querySelectorAll("#equipos-table tbody tr")[tooltipItem.dataIndex].querySelectorAll("td")[1].innerText; // Código del equipo
                            const price = tooltipItem.raw;
                            return `${code} Precio: L.${price.toFixed(2)}`;
                        }
                    }
                },
                legend: {
                    display: false // Ocultar la leyenda
                },
                annotation: {
                    annotations: {
                        costTotal: {
                            type: 'label',
                            xValue: labels[labels.length], // Posición del total en la última fecha
                            yValue: Math.min(...data) - (Math.max(...data) - Math.min(...data)) * 0.1,
                            backgroundColor: "rgba(0, 123, 255, 0.7)",
                            content: `Costo Total de los Equipos Mostrados: L.${totalCosto.toFixed(2)}`,
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: 10
                        }
                    }
                }
            }
        }
    });
});
</script>

<script>
    // Función para calcular el total del costo de los equipos
    function calcularTotalCostos() {
        let total = 0;
        let totalNeto = 0;
        let totalDepreciacion = 0;

        // Iterar sobre todas las filas de la tabla en la columna de costos
        document.querySelectorAll('#equipos-table tbody tr').forEach(row => {
            const costo = parseFloat(row.cells[7].textContent.replace('L.', '').replace(',', '').trim()) || 0; // Columna de Costo
            const depreciacion = parseFloat(row.cells[8].textContent.replace('L.', '').replace(',', '').trim()) || 0; // Columna de depreciación
            total += costo;
            totalDepreciacion += depreciacion; 
            totalNeto += (costo-depreciacion);
        });

        // Actualizar el contenedor del total
        document.getElementById('total-cost').textContent = total.toLocaleString('es-HN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        document.getElementById('depreciacion').textContent = totalDepreciacion.toLocaleString('es-HN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        document.getElementById('valor-neto').textContent = totalNeto.toLocaleString('es-HN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Ejecutar la función cuando la página haya cargado
    document.addEventListener('DOMContentLoaded', calcularTotalCostos);

    // Ejecutar la función cuando la página haya cargado
    document.addEventListener('DOMContentLoaded', calcularTotalCostos);

    // Ejecutar la función cuando la página haya cargado
    document.addEventListener('DOMContentLoaded', calcularTotalCostos);
</script>
    <!-- Fin -->
@stop

