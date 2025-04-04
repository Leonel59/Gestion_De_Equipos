@extends('adminlte::page')

@section('title', 'Reporte de Empleados')

@section('content')

<div class="row">
    <!-- Coloca el logo a la izquierda -->
    <div class="col-md-0">
        <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Empresa" class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
    </div>

    <div class="col-md-8">
            <h1 class="font-weight-bold, text-center text-primary" style="margin: 20px 0 0 40px; font-size: 1.8rem; font-family: 'Arial', sans-serif;">REPORTE DE EMPLEADOS</h1>
            <p class="text-dark" style="font-size: 1.2rem; font-family: 'Roboto', sans-serif; font-weight: 20; letter-spacing: 1px; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);">
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
        <div class="col-md-12 d-flex justify-content-start align-items-center">
            <!-- Botón PDF -->
            <div class="mr-3">
                <button id="download-pdf" class="btn btn-danger" style="font-size: 1.1rem; border-radius: 1.4rem;">
                Descargar PDF <i class="fas fa-download"></i>
                </button>
            </div>
            <!-- Botones de gráficos -->
            <div class="mr-3">
                <button id="btnGenerarGraficoSucursal" class="btn btn-primary mr-3" style="font-size: 1.1rem; border-radius: 1.4rem;">
                Gráfico Por Sucursal <i class="fas fa-chart-bar mr-2"></i>
                </button>
                <button id="btnGenerarGraficoArea" class="btn btn-primary" style="font-size: 1.1rem;        border-radius: 1.4rem;">
                Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>
                </button>
            </div>
        </div>
    </div>
    

    <!-- Tabla de Empleados -->
    <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
                        <h3 class="card-title mb-0">Empleados Registrados</h3>
                    </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered table-sm" style="border-radius: 5px;" id="empleados-table">
                        <thead>
                            <tr style="background-color: white;">
                                <th>Sucursal</th>
                                <th>Área</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
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
                                        @elseif($empleado['estado_empleado'] == 'Asignado') badge-warning text-dark
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
            background-color:rgb(246, 246, 246);
            color: black;
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

        /* Animación del botón de descarga */
        .btn-download .btn-chart {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-download.downloading .btn-chart.generating {
            background-color: #f0f0f0;
            color: #2F5597;
        }

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

        /* Icono de completado */
        .btn-download .fa-check, .btn-chart .fa-check {
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
    // Variables globales para control del gráfico
    let chartInstance = null;
    let currentChartType = null;

    // Función optimizada para renderizar gráficos
    function renderChart(type) {
        try {
            const rows = document.querySelectorAll("#empleados-table tbody tr");
            const counts = {};
            
            // Recolectar datos
            rows.forEach(row => {
                const columnIndex = type === 'sucursal' ? 0 : 1;
                const key = row.querySelectorAll("td")[columnIndex].innerText.trim();
                if (key) counts[key] = (counts[key] || 0) + 1;
            });

            // Configuración según tipo
            const config = {
                sucursal: {
                    label: "Empleados por Sucursal",
                    xAxisTitle: "Sucursales"
                },
                area: {
                    label: "Empleados por Área",
                    xAxisTitle: "Áreas"
                }
            };

            // Destruir gráfico anterior
            if (chartInstance) chartInstance.destroy();

            // Crear nuevo gráfico
            const ctx = document.getElementById("myChart").getContext("2d");
            chartInstance = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: Object.keys(counts),
                    datasets: [{
                        label: config[type].label,
                        data: Object.values(counts),
                        backgroundColor: "rgba(54, 162, 235, 0.7)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1
                    }]
                },
                options: getChartOptions(config[type].xAxisTitle)
            });
            
            return true;
        } catch (error) {
            console.error('Error al generar gráfico:', error);
            return false;
        }
    }

    // Función para opciones del gráfico
    function getChartOptions(xAxisTitle) {
        return {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: xAxisTitle,
                        color: "#003366",
                        font: { size: 14, weight: "bold" }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    title: {
                        display: true,
                        text: "Cantidad de Empleados",
                        color: "#003366",
                        font: { size: 14, weight: "bold" }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { size: 12, weight: 'bold' } }
                }
            }
        };
    }

    // Función común para manejar los botones de gráficos
    function handleChartButton(button, type) {
        const btn = button;
        const otherBtn = document.getElementById(type === 'sucursal' ? 'btnGenerarGraficoArea' : 'btnGenerarGraficoSucursal');
        const downloadBtn = document.getElementById('download-pdf');

        // Animación de carga
        btn.innerHTML = `</span> Generando... <span class="btn-loader"></span>`;
        btn.classList.add('generating');
        btn.disabled = true;
        otherBtn.disabled = true;
        downloadBtn.disabled = true;

        setTimeout(() => {
            const success = renderChart(type);
            
            // Animación de completado o error
            btn.innerHTML = `Gráfico Generado <i class="fas fa-check"></i>`;
            setTimeout(() => {
                btn.innerHTML = type === 'sucursal'
                    ? `Gráfico Por Sucursal <i class="fas fa-chart-bar mr-2"></i>`
                    : `Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>`;
                    
                btn.classList.remove('generating');
                btn.disabled = false;
                otherBtn.disabled = false;
                downloadBtn.disabled = false;
            }, 1500);
        }, 1000);
    }

    // Asignar eventos - SOLO UNA VEZ
    document.getElementById('btnGenerarGraficoSucursal').addEventListener('click', function() {
        handleChartButton(this, 'sucursal');
    });

    document.getElementById('btnGenerarGraficoArea').addEventListener('click', function() {
        handleChartButton(this, 'area');
    });

    // Manejo del botón de gráfico por área
    document.getElementById('btnGenerarGraficoArea').addEventListener('click', function() {
        const btn = this;
        const otherBtn = document.getElementById('btnGenerarGraficoSucursal');
        const downloadBtn = document.getElementById('download-pdf');

        // Animación de carga
        btn.innerHTML = `Generando... <span class="btn-loader"></span>`;
        btn.classList.add('generating');
        btn.disabled = true;
        otherBtn.disabled = true;
        downloadBtn.disabled = true;

        setTimeout(() => {
            const success = renderChart('area');
            
            if (success) {
                // Animación de completado
                btn.innerHTML = `Gráfico Generado <i class="fas fa-check"></i>`;
                setTimeout(() => {
                    btn.innerHTML = `Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>`;
                    btn.classList.remove('generating');
                    btn.disabled = false;
                    otherBtn.disabled = false;
                    downloadBtn.disabled = false;
                }, 1500);
            } else {
                btn.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Error`;
                setTimeout(() => {
                    btn.innerHTML = `Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>`;
                    btn.classList.remove('generating');
                    btn.disabled = false;
                    otherBtn.disabled = false;
                    downloadBtn.disabled = false;
                }, 1500);
            }
        }, 1000);
    });

    // Manejo del botón de gráfico por área
    document.getElementById('btnGenerarGraficoArea').addEventListener('click', function() {
        const btn = this;
        const otherBtn = document.getElementById('btnGenerarGraficoSucursal');
        const downloadBtn = document.getElementById('download-pdf');

        // Animación de carga
        btn.innerHTML = `<span class="btn-loader"></span> Generando...`;
        btn.classList.add('generating');
        btn.disabled = true;
        otherBtn.disabled = true;
        downloadBtn.disabled = true;

        setTimeout(() => {
            try {
                currentChartType = 'area';
                renderChart('area');
                
                // Animación de completado
                btn.innerHTML = `Gráfico Generado <i class="fas fa-check"></i>`;
                setTimeout(() => {
                    btn.innerHTML = `Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>`;
                    btn.classList.remove('generating');
                    btn.disabled = false;
                    otherBtn.disabled = false;
                    downloadBtn.disabled = false;
                }, 1500);
            } catch (error) {
                console.error('Error:', error);
                btn.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Error`;
                setTimeout(() => {
                    btn.innerHTML = `Gráfico Por Área <i class="fas fa-chart-bar mr-2"></i>`;
                    btn.classList.remove('generating');
                    btn.disabled = false;
                    otherBtn.disabled = false;
                    downloadBtn.disabled = false;
                }, 1500);
            }
        }, 1000);
    });

    // Función para generar PDF
    document.getElementById('download-pdf').addEventListener('click', async function() {
        const btn = this;
        const graphBtnSuc = document.getElementById('btnGenerarGraficoSucursal');
        const graphBtnArea = document.getElementById('btnGenerarGraficoArea');

        // Animación de carga
        btn.innerHTML = `Generando PDF... <span class="btn-loader"></span>`;
        btn.classList.add('downloading');
        btn.disabled = true;
        graphBtnSuc.disabled = true;
        graphBtnArea.disabled = true;

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });

        // Función para cargar logo
        async function loadLogo() {
            return new Promise((resolve, reject) => {
                const logo = new Image();
                logo.crossOrigin = 'Anonymous';
                const paths = [
                    'logo/empresafondo.png',
                    '../logo/empresafondo.png',
                    'assets/logo/empresafondo.png',
                    '/logo/empresafondo.png'
                ];
                
                let attempt = 0;
                
                function tryPath() {
                    if (attempt >= paths.length) {
                        reject(new Error('Logo no encontrado'));
                        return;
                    }
                    
                    logo.src = paths[attempt];
                    attempt++;
                    
                    logo.onload = () => {
                        const ratio = logo.width / logo.height;
                        const width = 40;
                        const height = width / ratio;
                        resolve({ img: logo, width, height });
                    };
                    
                    logo.onerror = tryPath;
                }
                
                tryPath();
            });
        }

        try {
            // Agregar logo
            try {
                const { img, width, height } = await loadLogo();
                doc.addImage(img, 'PNG', 15, 10, width, height);
                await generatePDF(doc, true);
            } catch {
                await generatePDF(doc, false);
            }
        } catch (error) {
            console.error('Error generando PDF:', error);
        } finally {
            // Animación de completado
            btn.innerHTML = `Descarga Completada <i class="fas fa-check"></i>`;
            setTimeout(() => {
                btn.innerHTML = `Descargar PDF <i class="fas fa-download"></i>`;
                btn.classList.remove('downloading');
                btn.disabled = false;
                graphBtnSuc.disabled = false;
                graphBtnArea.disabled = false;
            }, 1500);
        }

        // Función principal para generar contenido PDF
        async function generatePDF(pdfDoc, hasLogo) {
            const startY = hasLogo ? 50 : 40;
            
            // Encabezado
            pdfDoc.setFontSize(18);
            pdfDoc.setTextColor(60, 85, 151);
            pdfDoc.text('REPORTE DE EMPLEADOS', 105, hasLogo ? 25 : 20, { align: 'center' });
            
            pdfDoc.setFontSize(10);
            pdfDoc.setTextColor(0, 0, 0);
            pdfDoc.text('Recarga Veloz S.A. de C.V.', 105, hasLogo ? 32 : 27, { align: 'center' });
            pdfDoc.text(`Fecha: ${new Date().toLocaleDateString()}`, 105, hasLogo ? 39 : 34, { align: 'center' });
            pdfDoc.text('Boulevard Suyapa, Tegucigalpa, Francisco Morazán', 105, hasLogo ? 46 : 41, { align: 'center' });

            // Obtener datos de la tabla
            const table = document.getElementById('empleados-table');
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
            const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => {
                const cells = Array.from(tr.querySelectorAll('td'));
                return cells.map((td, index) => {
                    // Manejar estado (columna 5)
                    if (index === 5 && td.querySelector('.badge')) {
                        return td.querySelector('.badge').innerText;
                    }
                    return td.innerText;
                });
            });

            // Generar tabla en PDF
            pdfDoc.autoTable({
                head: [headers],
                body: rows,
                startY: startY,
                margin: { top: 20 },
                styles: {
                    fontSize: 8,
                    cellPadding: 2,
                    halign: 'center',
                    valign: 'middle',
                    textColor: [0, 0, 0],
                    lineColor: [200, 200, 200],
                    lineWidth: 0.1
                },
                headStyles: {
                    fillColor: [60, 85, 151],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    lineWidth: 0.1
                },
                columnStyles: {
                    0: { cellWidth: 25 }, // Sucursal
                    1: { cellWidth: 25 }, // Área
                    2: { cellWidth: 25 }, // Nombre
                    3: { cellWidth: 25 }, // Apellido
                    4: { cellWidth: 25 }, // Cargo
                    5: { cellWidth: 20 }, // Estado
                    6: { cellWidth: 25 }  // Fecha
                },
                didParseCell: function(data) {
                    // Colores para estados (columna 5)
                    if (data.column.index === 5 && data.cell.raw) {
                        const estado = data.cell.raw.trim().toLowerCase();
                        
                        //verificamos coincidencias exactas
                        if (estado === 'inactivo') {
                            data.cell.styles.fillColor = [255, 179, 186]; // Rojo intenso
                        } else if (estado === 'activo') {
                            data.cell.styles.fillColor = [198, 239, 206]; // Verde
                        } else if (estado === 'asignado') {
                            data.cell.styles.fillColor = [255, 229, 153]; // Amarillo
                        }
                        //verificamos contenidos por si hay variantes
                        else if (estado.includes('inactivo')) {
                            data.cell.styles.fillColor = [255, 179, 186];
                        } else if (estado.includes('activo')) {
                            data.cell.styles.fillColor = [198, 239, 206];
                        } else if (estado.includes('asignado')) {
                            data.cell.styles.fillColor = [255, 229, 153];
                        }
                    }
                }
            });

            // Total de empleados
            const finalY = pdfDoc.lastAutoTable.finalY + 10;
            pdfDoc.setFontSize(10);
            pdfDoc.setTextColor(0, 0, 0);
            pdfDoc.setFont('helvetica', 'bold');
            
            const total = document.getElementById('total-empleados').textContent;
            pdfDoc.text(`Total de Empleados Registrados: ${total}`, 14, finalY);

            // Pie de página
            const pageCount = pdfDoc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                pdfDoc.setPage(i);
                pdfDoc.setFontSize(8);
                pdfDoc.setTextColor(100);
                pdfDoc.text(`Página ${i} de ${pageCount}`, 105, 287, { align: 'center' });
                pdfDoc.text('Generado por Recarga Veloz S.A. de C.V.', 105, 293, { align: 'center' });
            }

            // Guardar PDF
            pdfDoc.save('reporte_empleados.pdf');
        }
    });

    // Función para calcular el total fijo de empleados
    function calcularTotalEmpleados() {
        const total = document.querySelectorAll('#empleados-table tbody tr').length;
        document.getElementById('total-empleados').textContent = total;
    }
    </script>

    <!-- Parte que agregue para el filtrado -->
    <script>
    $(document).ready(function () {
        // Inicializar DataTable
        var table = $('#empleados-table').DataTable({
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

    <script>
    document.getElementById("btnGenerarGraficoSucursal").addEventListener("click", function () {
    // Obtén los datos de la tabla
    const rows = document.querySelectorAll("#empleados-table tbody tr");
    const sucursalCounts = {};

    rows.forEach(row => {
        const sucursal = row.querySelectorAll("td")[0].innerText; // Nombre de la sucursal
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
                    ticks: {
                        stepSize: 1 
                    },
                    title: {
                        display: true,
                        text: "Cantidad de Empleados",
                        color: "#003366",
                        font: {
                            size: 14,
                            weight: "bold"
                        }
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
        const areas = row.querySelectorAll("td")[1].innerText; // Nombre del area
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
                    ticks: {
                        stepSize: 1 
                    },
                    title: {
                        display: true,
                        text: "Cantidad de Empleados",
                        color: "#003366",
                        font: {
                            size: 14,
                            weight: "bold"
                        }
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

