@extends('adminlte::page')

@section('title', 'Reporte de Equipos')


@section('content')

    <div class="row">
    <!-- Logo Recarga Veloz -->
    <div class="col-md-0">
        <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Recarga Veloz S.A. de C.V."class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
    </div>

    <div class="col-md-8">
            <h1 class="font-weight-bold, text-center text-primary" style="margin: 20px 0 0 40px; font-size: 1.8rem; font-family: 'Arial', sans-serif;">REPORTE DE EQUIPOS</h1>
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
        <div class="row mt-4 d-flex justify-content-align">
            <div class="col-md-2">
                <button id="download-pdf" class="btn btn-danger btn-block" style="font-size: 1.1rem; border-radius: 1.4rem;">
                Descargar PDF <i class="fas fa-download mr-2"></i>
                </button>
            </div>
            <!-- Botón Generar Gráfico-->
            <div class="col-md-2">
                <button id="btnGenerarGrafico" class="btn btn-primary btn-block" style="font-size: 1.1rem; border-radius: 1.4rem;">
                    Gráfico de Costo <i class="fas fa-chart-bar mr-2"></i>
                </button>
            </div>
        </div>

        <!-- Tabla de Equipos -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
                        <h3 class="card-title mb-0">Equipos Registrados</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered table-sm"  style="border-radius: 5px;" id="equipos-table">
                            <thead>
                                <tr style="background-color: white;">
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
                                        <td>{{ $equipo['cod_equipo'] }}</td>
                                        <td>{{ $equipo['tipo_equipo'] }}</td>
                                        <td>{{ $equipo['marca_equipo'] }}</td>
                                        <td>{{ $equipo['modelo_equipo'] }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($equipo['estado_equipo'] == 'Disponible') badge bg-success 
                                                @elseif($equipo['estado_equipo'] == 'En Mantenimiento') bg-danger text-white
                                                @elseif($equipo['estado_equipo'] == 'Comodin') badge-primary
                                                @elseif($equipo['estado_equipo'] == 'Asignado') badge bg-warning text-dark
                                                @endif">
                                                {{ $equipo['estado_equipo'] }}
                                            </span>
                                        </td>
                                        <td>{{ $equipo['numero_serie'] }}</td>
                                        <td>L.{{ number_format($equipo['precio_equipo'], 2) }}</td>
                                        <td>L.{{ number_format($equipo['depreciacion_equipo'], 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($equipo['fecha_adquisicion'])->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

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
                        <!--Parte del total-->

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
    document.getElementById('btnGenerarGrafico').addEventListener('click', function() {
    const graphBtn = document.getElementById('btnGenerarGrafico');
    const downloadBtn = document.getElementById('download-pdf');

    //Animación de carga
    graphBtn.innerHTML = `
    <span class="btn-loader"></span>
    <span>Generando Gráfico...</span>
    `;
    graphBtn.classList.add('generating');
    graphBtn.disabled = true;
    downloadBtn.disabled = true; // Deshabilitar también el de PDF durante la generación

    // Simulamos la generación del gráfico (reemplaza esto con tu lógica real)
    setTimeout(async () => {
        try {
        // Animación de completado
        graphBtn.innerHTML = 'Gráfico Completado <i class="fas fa-check"></i>';
        setTimeout(() => {
            graphBtn.innerHTML = '</i>Gráfico de Costo <i class="fas fa-chart-bar">';
            graphBtn.classList.remove('generating');
            graphBtn.disabled = false;
            downloadBtn.disabled = false;
    }, 2000);
        } catch (error) {
            console.error('Error generando gráfico:', error);
            graphBtn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error';
            setTimeout(() => {
                graphBtn.innerHTML = '</i>Gráfico de Costo <i class="fas fa-chart-bar">';
                graphBtn.classList.remove('generating');
                graphBtn.disabled = false;
                downloadBtn.disabled = false;
            }, 2000);
        }
        }, 1500); 
    });

    document.getElementById('download-pdf').addEventListener('click', async function() {
    // Ocultar botones temporalmente
    const downloadBtn = document.getElementById('download-pdf');

    //Animación de carga en el botón
    downloadBtn.innerHTML = `
        <span class="btn-loader"></span>
        <span>Generando PDF...</span>
    `;
    downloadBtn.classList.add('downloading');
    downloadBtn.disabled = true;

    // Crear nuevo PDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4'
    });

    //Función para cargar el logo
    async function loadLogo() {
        return new Promise((resolve, reject) => {
            const logo = new Image();
            logo.crossOrigin = 'Anonymous';
            
            // Intenta con varias rutas posibles
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
                    // Ajustar a formato rectangular (ancho mayor que alto)
                    const aspectRatio = logo.width / logo.height;
                    const displayWidth = 40; // Más ancho para forma rectangular
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

    //Generar el PDF
    try {
        const { img, width, height } = await loadLogo();
        // Posición del logo (15mm desde izquierda, 10mm desde arriba)
        doc.addImage(img, 'PNG', 15, 10, width, height);
        await generatePDFContent(doc, true);
    } catch (error) {
        console.warn('Generando PDF sin logo:', error.message);
        await generatePDFContent(doc, false);
    } finally {
        // Animación de completado
        downloadBtn.innerHTML = 'Descarga completada <i class="fas fa-check"></i>';
        setTimeout(() => {
            downloadBtn.innerHTML = '</i> Descargar PDF <i class="fas fa-download">';
            downloadBtn.classList.remove('downloading');
            downloadBtn.disabled = false;
            graphBtn.style.opacity = '1';
            graphBtn.disabled = false;
        }, 2000);
    }

    //Función principal con colores suaves
    async function generatePDFContent(pdfDoc, hasLogo) {
        // Configuración inicial
        const startY = hasLogo ? 50 : 40; 
        
        // Encabezado 
        pdfDoc.setFontSize(18);
        doc.setTextColor(60, 85, 151); 
        pdfDoc.text('REPORTE DE EQUIPOS', 105, hasLogo ? 25 : 20, { align: 'center' });
        
        pdfDoc.setFontSize(10);
        pdfDoc.setTextColor(0, 0, 0);
        pdfDoc.text('Recarga Veloz S.A. de C.V.', 105, hasLogo ? 32 : 27, { align: 'center' });
        pdfDoc.text(`Fecha: ${new Date().toLocaleDateString()}`, 105, hasLogo ? 39 : 34, { align: 'center' });
        pdfDoc.text('Boulevard Suyapa, Tegucigalpa, Francisco Morazán', 105, hasLogo ? 46 : 41, { align: 'center' });

        // Obtener datos de la tabla
        const table = document.getElementById('equipos-table');
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
        const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => 
            Array.from(tr.querySelectorAll('td')).map(td => td.innerText)
        );

        // Generar tabla con colores suaves
        pdfDoc.autoTable({
            head: [headers],
            body: rows,
            startY: startY,
            styles: {
                fontSize: 8,
                cellPadding: 1.9,
                halign: 'center',
                valign: 'middle',
                textColor: [0, 0, 0],
                lineColor: [200, 200, 200] // Bordes grises suaves
            },
            headStyles: {
                fillColor: [60, 85, 151], // Color del encabezado del Grid
                textColor: 255, // Texto blanco
                fontStyle: 'bold',
                lineWidth: 0.1
            },
            //Espacio entre celdas del encabezado
            columnStyles: {
                0: { cellWidth: 15, halign: 'center' },  // Código
                1: { cellWidth: 25, halign: 'center' },  // Tipo
                2: { cellWidth: 16, halign: 'center' },  // Marca
                3: { cellWidth: 25, halign: 'center' },  // Modelo
                4: { cellWidth: 25, halign: 'center' },  // Estado
                5: { cellWidth: 20, halign: 'center' },  // Numero de Serie
                6: { cellWidth: 20, halign: 'center' },  // Costo
                7: { cellWidth: 22, halign: 'center' },  // Depreciación
                8: { cellWidth: 20, halign: 'center' },  // Fecha Adquisición
            },
            didParseCell: function(data) {
                // Colores suaves para estados
                if (data.column.index === 4 && data.cell.raw) {
                    const estado = data.cell.raw.toLowerCase();
                    
                    if (estado.includes('asignado')) {
                        data.cell.styles.fillColor = [255, 229, 153]; // Naranja suave
                    } else if (estado.includes('mantenimiento')) {
                        data.cell.styles.fillColor = [255, 199, 206]; // Rojo suave
                    } else if (estado.includes('disponible')) {
                        data.cell.styles.fillColor = [198, 239, 206]; // Verde suave
                    } else if (estado.includes('comodín') || estado.includes('comodin')) {
                        data.cell.styles.fillColor = [189, 215, 238]; // Azul claro suave
                    }
                }
            }
        });

        // Totales
        const finalY = pdfDoc.lastAutoTable.finalY + 10;
        pdfDoc.setFontSize(10);
        pdfDoc.setTextColor(0, 0, 0);
        pdfDoc.setFont('helvetica', 'bold');
        
        const totalCost = document.getElementById('total-cost').textContent;
        const totalDepreciation = document.getElementById('depreciacion').textContent;
        const netValue = document.getElementById('valor-neto').textContent;
        
        pdfDoc.text(`Costo del Inventario Total: ${totalCost}`, 14, finalY);
        pdfDoc.text(`Depreciación Total: ${totalDepreciation}`, 14, finalY + 7);
        pdfDoc.text(`Valor Neto del Inventario: ${netValue}`, 14, finalY + 14);

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
        pdfDoc.save('reporte_equipos.pdf');
        }
    });
    </script>

    <!-- filtrado -->
    <script>
    $(document).ready(function () {
        // Inicializar DataTable
        var table = $('#equipos-table').DataTable({
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
    
    <!-- Script del Gráfico -->
    <script>
    function formato(numero) {
    return 'L.' + numero.toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, '$&.')
        .replace('.', ',');
    }
    document.getElementById("btnGenerarGrafico").addEventListener("click", function () {
    //Aqui se obtienen los datos de la tabla
    const rows = document.querySelectorAll("#equipos-table tbody tr");
    const labels = []; // Arreglo Para las fechas de adquisición
    const data = []; // Arreglo Para los precios
    let totalCosto = 0; // Variable para el costo total

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const fechaAdquisicion = cells[8].innerText; // Fecha de adquisición
        const precio = parseFloat(cells[6].innerText.replace("L.", "").replace(",", "")); // Precio del equipo

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
                    min: 0, 
                    suggestedMax: Math.max(...data) * 1.1, 
                    title: {
                        display: true,
                        text: 'Costo (Lempiras)'
                    },
                    ticks: {
                    //Esta función evita que se generen valores negativos en el gráfico
                    callback: function(value) {
                        if(value < 0) return ''; 
                            return 'L.' + value.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    },
                        stepSize: 5000 // Este valor se puede ajustar para modificar la distancia entre costo en el eje Y
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        // Elimina el título que muestra el timestamp
            title: function() {
                return []; // Retorna array vacío para no mostrar título
            },
            // Personaliza el contenido del tooltip
            label: function(tooltipItem) {
                const row = document.querySelectorAll("#equipos-table tbody tr")[tooltipItem.dataIndex];
                const cells = row.querySelectorAll("td");
                
                const codigo = cells[0].innerText; // Código del equipo
                const fechaAdquisicion = cells[8].innerText; // Fecha de adquisición
                const precio = parseFloat(cells[6].innerText.replace("L.", "").replace(/,/g, ''));
                
                return [
                    `Código: ${codigo}`,
                    `Fecha Adquisición: ${fechaAdquisicion}`,
                    `Costo: L.${precio.toLocaleString('en-US', {minimumFractionDigits: 2})}`
                ];
            }
        },
        displayColors: false,
        backgroundColor: 'rgba(0,0,0,0.8)',
        bodyFont: {
            size: 12,
            family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif"
                    }
                },
                legend: {
                    display: false // Ocultar la leyenda
                },
                annotation: {
                annotations: {
                    totalAnnotation: {
                        type: 'label',
                        content: [
                            `Costo Total de los Equipos Mostrados: L. ${totalCosto.toLocaleString("es-HN", { minimumFractionDigits: 2 })}`,
                            `Equipos Mostrados: ${rows.length}`
                        ],
                        position: 'bottom',
                        yValue: 0,
                        yAdjust: -30,
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
            const costo = parseFloat(row.cells[6].textContent.replace('L.', '').replace(',', '').trim()) || 0; // Columna de Costo
            const depreciacion = parseFloat(row.cells[7].textContent.replace('L.', '').replace(',', '').trim()) || 0; // Columna de depreciación
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
