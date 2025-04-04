@extends('adminlte::page')

@section('title', 'Reporte de Servicios de Mantenimiento')

@section('content')

<div class="row align-items-center">
    <!-- Logo Recarga Veloz -->
    <div class="col-md-0">
            <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Recarga Veloz S.A. de C.V." class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
        </div>
        <div class="col-md-8">
            <h1 class="font-weight-bold, text-center text-primary" style="margin: 20px 0 0 40px; font-size: 1.8rem; font-family: 'Arial', sans-serif;">REPORTE DE SERVICIOS</h1>
            <p class="text-dark" style="font-size: 1.2rem; font-family: 'Roboto', sans-serif; font-weight: 20; letter-spacing: 1px; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);">
                Recarga Veloz S.A. de C.V
            </p>
        </div>
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
    <div class="row mt-4 d-flex justify-content-align">
            <div class="col-md-2">
                <button id="download-pdf" class="btn btn-danger btn-block" style="font-size: 1.1rem; border-radius: 1.4rem;">
                Descargar PDF <i class="fas fa-download mr-2"></i>
                </button>
            </div>
            <!-- Botón Generar Gráfico-->
            <div class="col-md-3">
            <button id="btnGenerarGraficoMantenimientos" class="btn btn-primary btn-block" style="font-size: 1.1rem; border-radius: 1.4rem;">
            Gráfico de Servicios <i class="fas fa-chart-bar mr-2"></i>
            </button>
        </div>
    </div>

    <!-- Tabla de Servicios -->
    <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
                        <h3 class="card-title mb-0">Mantenimientos Registrados</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered table-sm"  style="border-radius: 5px;" id="servicios-table">
                            <thead>
                                <tr style="background-color: white;">
                                    <th>Equipo</th>
                                    <th>Tipo Mantenimiento</th>
                                    <th>Descripción</th>
                                    <th>Duración (Horas)</th>
                                    <th>Fecha Reparación</th>
                                    <th>Fecha Entrega</th>
                                    <th>Costo Servicio</th>
                                    <th>Producto</th>
                                    <th>Cantidad Producto</th>
                                    <th>Costo Producto</th>
                                    <th>Total</th>
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
                                        <td>{{ $servicio['duracion_mantenimiento'] ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($servicio['fecha_reparacion_equipo'])->format('d/m/Y ') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($servicio['fecha_entrega_equipo'])->format('d/m/Y ') }}</td>
                                        <td>L.{{ number_format($costo_mantenimiento, 2) }}</td>
                                        <td>{{ $servicio['nombre_producto'] ?? 'N/A' }}</td>
                                        <td>{{ $servicio['cantidad_producto'] ?? 'N/A' }}</td>
                                        <td>L.{{ number_format($costo_producto, 2) }}</td>
                                        <td>L.{{ number_format($total, 2) }}</td>
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
            font-size: 0.8rem;
        }

        .table th {
            background-color:rgb(246, 246, 246);
            color: black;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 50%; /* Logo redondeado */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    
    <script>
    // Animación para el botón de gráfico
    document.getElementById('btnGenerarGraficoMantenimientos').addEventListener('click', function() {
        const graphBtn = document.getElementById('btnGenerarGraficoMantenimientos');
        const downloadBtn = document.getElementById('download-pdf');

        // Animación de carga
        graphBtn.innerHTML = `
        <span class="btn-loader"></span>
        <span>Generando Gráfico...</span>
        `;
        graphBtn.classList.add('generating');
        graphBtn.disabled = true;
        downloadBtn.disabled = true;

        // Lógica del gráfico
        setTimeout(() => {
            try {
                generarGraficoMantenimientos();
                
                // Animación de completado
                graphBtn.innerHTML = 'Gráfico Completado <i class="fas fa-check"></i>';
                setTimeout(() => {
                    graphBtn.innerHTML = '</i>Gráfico de Servicios <i class="fas fa-chart-bar">';
                    graphBtn.classList.remove('generating');
                    graphBtn.disabled = false;
                    downloadBtn.disabled = false;
                }, 2000);
            } catch (error) {
                console.error('Error generando gráfico:', error);
                graphBtn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error';
                setTimeout(() => {
                    graphBtn.innerHTML = '</i>Gráfico de Servicios <i class="fas fa-chart-bar">';
                    graphBtn.classList.remove('generating');
                    graphBtn.disabled = false;
                    downloadBtn.disabled = false;
                }, 2000);
            }
        }, 500);
    });

    // Función para generar el gráfico
    function generarGraficoMantenimientos() {
        const rows = document.querySelectorAll("#servicios-table tbody tr");
        const labels = [];
        const data = [];
        let totalCosto = 0;

        rows.forEach(row => {
            const cells = row.querySelectorAll("td");
            const codigoEquipo = cells[0].innerText;
            const fechaMantenimiento = cells[4].innerText;
            const costo = parseFloat(cells[10].innerText.replace("L.", "").replace(",", ""));

            labels.push(`${codigoEquipo} (${fechaMantenimiento})`);
            data.push(costo);
            totalCosto += costo;
        });

        if (window.myChartInstance) {
            window.myChartInstance.destroy();
        }

        const ctx = document.getElementById("myChart").getContext("2d");
        window.myChartInstance = new Chart(ctx, {
            type: "bar",
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
                                content: [
                                    `Costo Total de los Servicios Mostrados: L. ${totalCosto.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`,
                                    `Servicios Mostrados: ${labels.length}`
                                ],
                                position: {
                                    x: 'center',
                                    y: 'top'
                                },
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                color: '#fff',
                                padding: 10,
                                borderRadius: 5,
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                xAdjust: 0,
                                yAdjust: -20
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
    }

    // Animación para el botón de PDF
    document.getElementById('download-pdf').addEventListener('click', async function() {
        const downloadBtn = document.getElementById('download-pdf');
        const graphBtn = document.getElementById('btnGenerarGraficoMantenimientos');
        
        // Ocultar elementos de DataTables
        const elementsToHide = [
            '.dataTables_filter',
            '.dataTables_info',
            '.dataTables_sort',
            '.dataTables_length',
            '.dataTables_paginate',
            '#filtrado'
        ];
        
        const hiddenElements = [];
        elementsToHide.forEach(selector => {
            const element = document.querySelector(selector);
            if (element) {
                hiddenElements.push({element, originalDisplay: element.style.display});
                element.style.display = 'none';
            }
        });

        // Animación de carga
        downloadBtn.innerHTML = `<span class="btn-loader"></span><span>Generando PDF...</span>`;
        downloadBtn.classList.add('downloading');
        downloadBtn.disabled = true;
        graphBtn.disabled = true;

        // Crear nuevo PDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });

        // Función para cargar el logo
        async function loadLogo() {
            return new Promise((resolve, reject) => {
                const logo = new Image();
                logo.crossOrigin = 'Anonymous';
                
                const logoPaths = [
                    'logo/empresafondo.png',
                    '../logo/empresafondo.png',
                    './assets/logo/empresafondo.png',
                    '/logo/empresafondo.png'
                ];
                
                let attempts = 0;
                
                function tryNextPath() {
                    if (attempts >= logoPaths.length) {
                        reject(new Error('No se pudo cargar el logo'));
                        return;
                    }
                    
                    logo.src = logoPaths[attempts];
                    attempts++;
                    
                    logo.onload = () => {
                        const aspectRatio = logo.width / logo.height;
                        const displayWidth = 40;
                        const displayHeight = displayWidth / aspectRatio;
                        
                        resolve({ 
                            img: logo, 
                            width: displayWidth, 
                            height: displayHeight 
                        });
                    };
                    
                    logo.onerror = tryNextPath;
                }
                
                tryNextPath();
            });
        }

        // Generar el PDF
        try {
            const { img, width, height } = await loadLogo();
            doc.addImage(img, 'PNG', 15, 10, width, height);
            await generatePDFContent(doc, true);
        } catch (error) {
            console.warn('Generando PDF sin logo:', error.message);
            await generatePDFContent(doc, false);
        } finally {
            // Restaurar elementos ocultos
            hiddenElements.forEach(item => {
                item.element.style.display = item.originalDisplay;
            });

            // Animación de completado
            downloadBtn.innerHTML = 'Descarga completada <i class="fas fa-check"></i>';
            setTimeout(() => {
                downloadBtn.innerHTML = '</i> Descargar PDF <i class="fas fa-download">';
                downloadBtn.classList.remove('downloading');
                downloadBtn.disabled = false;
                graphBtn.disabled = false;
            }, 2000);
        }

        // Función para generar contenido PDF
        async function generatePDFContent(pdfDoc, hasLogo) {
            const startY = hasLogo ? 50 : 40;
            
            // Encabezado 
            pdfDoc.setFontSize(18);
            pdfDoc.setTextColor(60, 85, 151);
            pdfDoc.text('REPORTE DE SERVICIOS', 105, hasLogo ? 25 : 20, { align: 'center' });
            
            pdfDoc.setFontSize(10);
            pdfDoc.setTextColor(0, 0, 0);
            pdfDoc.text('Recarga Veloz S.A. de C.V.', 105, hasLogo ? 32 : 27, { align: 'center' });
            pdfDoc.text(`Fecha: ${new Date().toLocaleDateString()}`, 105, hasLogo ? 39 : 34, { align: 'center' });
            pdfDoc.text('Boulevard Suyapa, Tegucigalpa, Francisco Morazán', 105, hasLogo ? 46 : 41, { align: 'center' });

            // Obtener datos de la tabla
            const table = document.getElementById('servicios-table');
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
            const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => 
                Array.from(tr.querySelectorAll('td')).map(td => td.innerText)
            );

            // Generar tabla
            pdfDoc.autoTable({
                head: [headers],
                body: rows,
                startY: startY,
                styles: {
                    fontSize: 7,
                    cellPadding: 1.5,
                    halign: 'center',
                    valign: 'middle',
                    textColor: [0, 0, 0],
                    lineColor: [200, 200, 200]
                },
                headStyles: {
                    fillColor: [60, 85, 151],
                    textColor: 255,
                    fontStyle: 'bold',
                    lineWidth: 0.1
                },
                columnStyles: {
                    0: { cellWidth: 'auto' },
                    1: { cellWidth: 'auto' },
                    2: { cellWidth: 'auto' },
                    3: { cellWidth: 'auto' },
                    4: { cellWidth: 'auto' },
                    5: { cellWidth: 'auto' },
                    6: { cellWidth: 'auto' },
                    7: { cellWidth: 'auto' },
                    8: { cellWidth: 'auto' },
                    9: { cellWidth: 'auto' },
                    10: { cellWidth: 'auto' }
                }
            });

            // Totales
            const totalMantenimientos = document.getElementById('total-Mant').textContent;
            const finalY = pdfDoc.lastAutoTable.finalY + 10;
            pdfDoc.setFontSize(10);
            pdfDoc.setTextColor(0, 0, 0);
            pdfDoc.setFont('helvetica', 'bold');
            pdfDoc.text(`Costo Total de Mantenimientos: L.${totalMantenimientos}`, 14, finalY);

            // Pie de página
            const pageCount = pdfDoc.internal.getNumberOfPages();
            for(let i = 1; i <= pageCount; i++) {
                pdfDoc.setPage(i);
                pdfDoc.setFontSize(8);
                pdfDoc.setTextColor(100);
                pdfDoc.text(`Página ${i} de ${pageCount}`, 105, 287, { align: 'center' });
                pdfDoc.text('Generado por Recarga Veloz S.A. de C.V.', 105, 293, { align: 'center' });
            }

            // Guardar PDF
            pdfDoc.save('reporte_servicios.pdf');
        }
    });
    </script>

    <!-- Parte para el filtrado -->
    <script>
    $(document).ready(function () {
        // Inicializar DataTable
        var table = $('#servicios-table').DataTable({
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
        // Función para calcular el total del costo de los equipos
        function calcularTotalMantenimiento() {
            let total = 0;

            // Iterar sobre todas las filas de la tabla en la columna de costos
            document.querySelectorAll('#servicios-table tbody tr').forEach(row => {
                const costo = parseFloat(row.cells[10].textContent.replace('L.', '').replace(',', '').trim()) ||    0; // Columna del Total
                total += costo;
            });

            // Actualizar el contenedor del total
            document.getElementById('total-Mant').textContent = total.toLocaleString('es-HN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Ejecutar la función cuando la página este cargada
        document.addEventListener('DOMContentLoaded', calcularTotalMantenimiento);
    </script>
    <!-- Fin -->
@stop





