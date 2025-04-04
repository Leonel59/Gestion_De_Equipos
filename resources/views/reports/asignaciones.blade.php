@extends('adminlte::page')

@section('title', 'Reporte de Asignaciones')

@section('content')

<div class="row">
<!-- Logo Recarga Veloz -->
        <div class="col-md-0">
            <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Recarga Veloz S.A. de C.V." class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
        </div>

        <div class="col-md-8">
            <h1 class="font-weight-bold, text-center text-primary" style="margin: 20px 0 0 40px; font-size: 1.8rem; font-family: 'Arial', sans-serif;">REPORTE DE ASIGNACIONES</h1>
            <p class="text-dark" style="font-size: 1.2rem; font-family: 'Roboto', sans-serif; font-weight: 20; letter-spacing: 1px; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);">
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
    <div class="row mt-4 d-flex justify-content-align">
        <div class="col-md-2">
            <button id="download-pdf" class="btn btn-danger btn-block" style="font-size: 1.1rem; border-radius: 1.4rem;">
            Descargar PDF <i class="fas fa-download mr-2"></i>
            </button>
        </div>
        <!-- Botones de gráficos -->
        <div class="mr-3">
            <button id="btnGenerarGraficoAsignacionesSucursal" class="btn btn-primary mr-3" style="font-size: 1.1rem;border-radius: 1.4rem;">
            Gráfico Por Sucursal <i class="fas fa-chart-bar mr-2"></i>
            </button>
            <button id="btnGenerarGraficoAsignacionesArea" class="btn btn-primary" style="font-size: 1.1rem; border-radius: 1.4rem;">
            Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>
            </button>
        </div>
    </div>

    <!-- Tabla de Asignaciones -->
    <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
                        <h3 class="card-title mb-0">Asignaciones Registradas</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered table-sm"  style="border-radius: 5px;" id="asignaciones-table">
                            <thead>
                                <tr style="background-color: white;">
                                    <th>Equipo</th>
                                    <th>Empleado</th>
                                    <th>Sucursal</th>
                                    <th>Área</th>
                                    <th>Detalles de Asignación</th>
                                    <th>Suministro Asignado</th>
                                    <th>Costo Equipo</th>
                                    <th>Costo Suministros</th>
                                    <th>Fecha de Asignación</th>
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
                                        <td>L.{{ number_format($asignacion['costo_total_asignado'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Contenedor del costo total,  -->
                        <div id="totalAsignados-container" class="mt-3 text-right">
                            <h5><strong>Equipos Asignados:</strong> <span id="total-asignado">0</span></h5>
                        </div>
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

        /* Animaciones para botones */
        .btn-loader {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 3px solid rgba(47, 85, 151, 0.3);
            border-radius: 50%;
            border-top-color: #2F5597;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
            vertical-align: middle;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-download.downloading, 
        .btn-chart.generating {
            opacity: 0.8;
            position: relative;
        }

        .btn-download .fa-check, 
        .btn-chart .fa-check {
            color: #28a745;
            margin-right: 5px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <script>
    //Lógica de Descarga PDF y De las animaciones de los gráficos
    document.getElementById('download-pdf').addEventListener('click', async function() {
    const btn = this;
    const graphBtnSuc = document.getElementById('btnGenerarGraficoAsignacionesSucursal');
    const graphBtnArea = document.getElementById('btnGenerarGraficoAsignacionesArea');
    
    // Animación de carga
    btn.innerHTML = `<span class="btn-loader"></span> Generando PDF...`;
    btn.classList.add('downloading');
    btn.disabled = true;
    if(graphBtnSuc) graphBtnSuc.disabled = true;
    if(graphBtnArea) graphBtnArea.disabled = true;
    
    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'landscape',
            unit: 'mm',
            format: 'a4'
        });
    
        // Configuración inicial
        const margin = 15;
        let yPos = margin;
        const pageWidth = doc.internal.pageSize.getWidth();
        
        //Logo 
        try {
            const logoData = await getImageData('{{ asset("logo/empresafondo.png") }}');
            const logoWidth = 30;
            const logoHeight = logoWidth * (logoData.height / logoData.width);
            doc.addImage(logoData, 'PNG', margin, yPos, logoWidth, logoHeight);
            yPos += logoHeight + 5;
        } catch (error) {
            console.log('Logo no cargado, continuando sin él');
            yPos += 10;
        }
    
        // Encabezado 
        doc.setFontSize(16);
        doc.setTextColor(60, 85, 151);
        doc.setFont('helvetica', 'bold');
        doc.text('REPORTE DE ASIGNACIONES', pageWidth / 2, yPos, { align: 'center' });
        
        doc.setFontSize(12);
        doc.setTextColor(0, 0, 0);
        doc.setFont('helvetica', 'normal');
        doc.text('Recarga Veloz S.A. de C.V.', pageWidth / 2, yPos + 7, { align: 'center' });
        
        doc.setFontSize(10);
        doc.text(`Fecha: ${new Date().toLocaleDateString()}`, pageWidth / 2, yPos + 14, { align: 'center' });
        doc.text('Boulevard Suyapa, Tegucigalpa, Francisco Morazán', pageWidth / 2, yPos + 19, { align:    'center' });
        
        yPos += 30;
    
        // Obtener datos de la tabla
        const tableData = getTableData();
        
        // Aqui se Configuran estilos para montos en lempiras
        const currencyFormatter = (value) => {
            return `L. ${parseFloat(value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        };
    
        // Generar tabla en PDF
        doc.autoTable({
        head: [tableData.headers],
        body: tableData.rows,
        startY: yPos,
        margin: { 
            top: yPos,
            left: (doc.internal.pageSize.getWidth() - 250) / 2, // Centrado manual basado en ancho fijo
            right: 0
        },
        tableWidth: 250, // Ancho fijo en mm para mejor control del centrado
        styles: {
            fontSize: 7,
            cellPadding: 1.5,
            halign: 'center',
            valign: 'middle',
            textColor: [0, 0, 0],
            lineColor: [200, 200, 200],
            lineWidth: 0.1,
            overflow: 'linebreak'
        },
        headStyles: {
            fillColor: [60, 85, 151],
            textColor: [255, 255, 255],
            fontStyle: 'bold',
            lineWidth: 0.1
        },
        columnStyles: {
            0: { cellWidth: 'auto', minCellWidth: 25 }, // Equipo 
            1: { cellWidth: 'auto', minCellWidth: 25 }, // Empleado
            2: { cellWidth: 'auto', minCellWidth: 25 }, // Sucursal
            3: { cellWidth: 'auto', minCellWidth: 25 }, // Área
            4: { cellWidth: 'auto', minCellWidth: 25 }, // Detalles
            5: { cellWidth: 'auto', minCellWidth: 25 }, // Suministro
            6: { 
                cellWidth: 'auto',
                minCellWidth: 25,
                halign: 'right',
                render: (cellData) => currencyFormatter(cellData)
            },
            7: { 
                cellWidth: 'auto',
                minCellWidth: 25,
                halign: 'right',
                render: (cellData) => currencyFormatter(cellData)
            },
            8: { cellWidth: 'auto', minCellWidth: 20 }, // Fecha
            9: { 
                cellWidth: 'auto',
                minCellWidth: 25,
                halign: 'right',
                render: (cellData) => currencyFormatter(cellData)
            }
        },

        // Mejora de manejo de tablas largas
        didDrawPage: function(data) {},
        // Mejorar el cálculo del ancho de columnas
        columnWidth: 'wrap' 
        });
    
        // Pie de página 
        addFooter(doc);
    
        // Guardar PDF
        doc.save('reporte_asignaciones.pdf');
    
        } catch (error) {
            console.error('Error generando PDF:', error);
            alert('Ocurrió un error al generar el PDF. Por favor intente nuevamente.');
        } finally {
            // Restaurar botón con animación 
            btn.innerHTML = `Descarga Completada <i class="fas fa-check-circle"></i> `;
            setTimeout(() => {
                btn.innerHTML = `Descargar PDF <i class="fas fa-download"></i>`;
                btn.classList.remove('downloading');
                btn.disabled = false;
                if(graphBtnSuc) graphBtnSuc.disabled = false;
                if(graphBtnArea) graphBtnArea.disabled = false;
            }, 1500);
        }
    });

// Función para animaciones de los botones de gráficos
function animateChartButton(button, chartType) {
    const btn = button;
    const otherBtn = chartType === 'sucursal' 
        ? document.getElementById('btnGenerarGraficoAsignacionesArea') 
        : document.getElementById('btnGenerarGraficoAsignacionesSucursal');
    const downloadBtn = document.getElementById('download-pdf');

    // Animación de carga
    btn.innerHTML = `<span class="btn-loader"></span> Generando...`;
    btn.classList.add('generating');
    btn.disabled = true;
    if(otherBtn) otherBtn.disabled = true;
    if(downloadBtn) downloadBtn.disabled = true;

    setTimeout(() => {
        // Animación de completado
        btn.innerHTML = `Gráfico Generado <i class="fas fa-check"></i>`;
        setTimeout(() => {
            btn.innerHTML = chartType === 'sucursal' 
                ? `Gráfico Por Sucursal <i class="fas fa-chart-bar mr-2"></i>` 
                : `Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>`;
            btn.classList.remove('generating');
            btn.disabled = false;
            if(otherBtn) otherBtn.disabled = false;
            if(downloadBtn) downloadBtn.disabled = false;
        }, 1500);
    }, 1000);
}

// Asignar eventos a los botones de gráficos
document.getElementById('btnGenerarGraficoAsignacionesSucursal')?.addEventListener('click', function() {
    animateChartButton(this, 'sucursal');
});

document.getElementById('btnGenerarGraficoAsignacionesArea')?.addEventListener('click', function() {
    animateChartButton(this, 'area');
});

// Funciones auxiliares
function getTableData() {
    const table = document.getElementById('asignaciones-table');
    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => {
        return Array.from(tr.querySelectorAll('td')).map(td => td.innerText);
    });
    
    const total = document.getElementById('total-asignado').textContent;
    
    return { headers, rows, total };
}

    //Pie de página
    function addFooter(doc) {
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFontSize(8);
            doc.setTextColor(100);
            doc.text(`Página ${i} de ${pageCount}`, doc.internal.pageSize.getWidth() / 2, doc.internal. pageSize.   getHeight() - 10, { align: 'center' });
            doc.text('Generado por Recarga Veloz S.A. de C.V.', doc.internal.pageSize.getWidth() / 2, doc.  internal.pageSize.getHeight() - 5, { align: 'center' });
        }
    }

    function getImageData(url) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.crossOrigin = 'Anonymous';
            img.src = url;
            img.onload = () => resolve(img);
            img.onerror = reject;
        });
    }
    </script>

    <!-- Parte para el filtrado -->
    <script>
    $(document).ready(function () {
        // Inicializar DataTable
        var table = $('#asignaciones-table').DataTable({
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                paginate: { previous: "Anterior", next: "Siguiente" }
            },
            //Filtrado personalizado 
            lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]], // Opciones de registros por página
        });
    });
    </script>

    <!-- Script Del Gráfico -->
    <script>
    document.getElementById("btnGenerarGraficoAsignacionesSucursal").addEventListener("click", function () {
    // Obtener los datos de la tabla
    const rows = document.querySelectorAll("#asignaciones-table tbody tr");
    const sucursales = {}; // Objeto para almacenar las asignaciones por sucursal
    let totalCostoEquipos = 0; // Variable para calcular el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const sucursal = cells[2].innerText; // Nombre de la sucursal
        const costoEquipo = parseFloat(cells[9].innerText.replace("L.", "").replace(",", "")); // Costo del equipo asignado

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

    // Viñeta debajo del gráfico con el costo total
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
    document.getElementById("btnGenerarGraficoAsignacionesArea").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#asignaciones-table tbody tr");
    const areas = {}; // Objeto para almacenar las asignaciones por área
    let totalCostoEquipos = 0; // Variable para calcular el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const area = cells[3].innerText; // Cambia al índice correcto para obtener el área
        const costoEquipo = parseFloat(cells[9].innerText.replace("L.", "").replace(",", "")); // Costo del equipo asignado

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
