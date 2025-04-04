@extends('adminlte::page')

@section('title', 'Reporte de Proveedores')

@section('content')

<div class="row">
<!-- Coloca el logo a la izquierda -->
        <div class="col-md-0">
            <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo de Recarga Veloz S.A. de C.V." class="img-fluid rounded-circle" style="max-width: 150px; margin: 20px 0 0 20px">
        </div>

        <div class="col-md-8">
            <h1 class="font-weight-bold, text-center text-primary" style="margin: 20px 0 0 40px; font-size: 1.8rem; font-family: 'Arial', sans-serif;">REPORTE DE PROOVEDORES</h1>
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
        </div>

    <!-- Tabla de Proveedores -->
    <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
                        <h3 class="card-title mb-0">Proveedores Registrados</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered table-sm"  style="border-radius: 5px;" id="proveedores-table">
                            <thead>
                                <tr style="background-color: white;">
                                <th>Proveedor</th>
                                <th>RTN</th>
                                <th>Contacto</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Departamento</th>
                                <th>Teléfono</th>
                                <th>Tipo Factura</th>
                                <th>Email</th>
                                <th>Fecha Facturacion</th>
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
                                    <td>{{ $proveedor['tipo_factura'] }}</td>
                                    <td>{{ $proveedor['correo_personal'] }}</td>
                                    <td>{{ $proveedor['fecha_facturacion'] }}</td>
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
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    
    <script>
        // Animación para el botón de PDF
    document.getElementById('download-pdf').addEventListener('click', async function() {
        const downloadBtn = document.getElementById('download-pdf');
        
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
            }, 2000);
        }

        // Función para generar contenido PDF
        async function generatePDFContent(pdfDoc, hasLogo) {
            const startY = hasLogo ? 50 : 40;
            
            // Encabezado 
            pdfDoc.setFontSize(18);
            pdfDoc.setTextColor(60, 85, 151);
            pdfDoc.text('REPORTE DE PROVEEDORES', 105, hasLogo ? 25 : 20, { align: 'center' });
            
            pdfDoc.setFontSize(10);
            pdfDoc.setTextColor(0, 0, 0);
            pdfDoc.text('Recarga Veloz S.A. de C.V.', 105, hasLogo ? 32 : 27, { align: 'center' });
            pdfDoc.text(`Fecha: ${new Date().toLocaleDateString()}`, 105, hasLogo ? 39 : 34, { align: 'center' });
            pdfDoc.text('Boulevard Suyapa, Tegucigalpa, Francisco Morazán', 105, hasLogo ? 46 : 41, { align: 'center' });

            // Obtener datos de la tabla
            const table = document.getElementById('proveedores-table');
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
                    0: { cellWidth: 15, halign: 'center' },  // Proveedor
                    1: { cellWidth: 15, halign: 'center' },  // RTN
                    2: { cellWidth: 20, halign: 'center' },  // Contacto
                    3: { cellWidth: 20, halign: 'center' },  // Dirección
                    4: { cellWidth: 17, halign: 'center' },  // Ciudad
                    5: { cellWidth: 20, halign: 'center' },  // Departamento
                    6: { cellWidth: 20, halign: 'center' },  // Telefono
                    7: { cellWidth: 20, halign: 'center' },  // Tipo Factura
                    8: { cellWidth: 20, halign: 'center' },  // Email
                    9: { cellWidth: 20, halign: 'center' },  // Fecha 
                }
            });

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
            pdfDoc.save('reporte_proveedores.pdf');
        }
    });
    </script>

    <!-- Parte que agregue para el filtrado -->
    <script>
    $(document).ready(function () {
        // Inicializar DataTable
        var table = $('#proveedores-table').DataTable({
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

@stop

