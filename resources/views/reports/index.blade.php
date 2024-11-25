@extends('adminlte::page')

@section('title', 'Administrar Reportes')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Administrar Reportes</h1>
@stop

@section('content')
   <!-- Contenedor principal con límite de ancho -->
<div class="container" style="max-width: 810px; margin: 0 auto;">
    <!-- Contenedor para logo y título -->
    <div class="d-flex justify-content-between align-items-center" style="background: linear-gradient(to right, #28a745, #007bff); padding: 10px 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <!-- Logo -->
        <img src="{{ asset('logo/empresafondo.png') }}" alt="Logo" style="width: 80px; height: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <!-- Título -->
        <h1 class="text-white font-weight-bold" style="font-size: 1.75rem;">Recarga Veloz</h1>
    </div>
</div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- Panel de creación de reporte -->
            <div class="col-md-8">
                <div class="card shadow-lg mb-5" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-header" style="background-color: #f1f5f8; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h5 class="card-title text-primary">Generar Nuevo Reporte</h5>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <form id="reportForm" action="{{ route('reportes.equipos') }}" method="GET">
                            <div class="form-group mb-4">
                                <label for="reporteNombre" style="font-weight: 500; color: #333;">Nombre del Reporte</label>
                                <input type="text" class="form-control form-control-lg" id="reporteNombre" name="reporteNombre" placeholder="Ingrese el nombre del reporte" required style="border-radius: 8px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12), inset 0 1px 2px rgba(0, 0, 0, 0.24);">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-radius: 8px; font-size: 1.1rem; padding: 12px 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <i class="fas fa-file-pdf"></i> Generar Reporte
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <style>
        .container-fluid {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .card-header {
            background-color: #f1f5f8;
            border-radius: 12px 12px 0 0;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            font-size: 1rem;
            padding: 12px;
            border-radius: 8px;
        }

        .btn i {
            margin-right: 10px;
        }

        .btn-lg {
            font-size: 1.1rem;
            padding: 12px 20px;
            border-radius: 8px;
        }

        /* Fondo extendido para mejorar el diseño visual */
        body {
            background-color: #f7f9fc;
        }

        /* Agregar sombra en los botones */
        .btn:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container-fluid {
            max-width: 1300px;
        }

        /* Efecto de sombras sutiles en la tarjeta */
        .card.shadow-lg {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 10px;
        }

        /* Estilo del formulario */
        .form-control {
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12), inset 0 1px 2px rgba(0, 0, 0, 0.24);
        }
    </style>
@stop

@section('js')
    <script>
        // Cambiar la acción del formulario dependiendo del nombre del reporte
        document.getElementById('reportForm').addEventListener('submit', function (e) {
            const reporteNombre = document.getElementById('reporteNombre').value.trim().toLowerCase();
            const form = e.target;

            // Cambiar la ruta de la acción dependiendo del nombre ingresado
            if (reporteNombre === 'equipos') {
                form.action = "{{ route('reportes.equipos') }}";
            } else if (reporteNombre === 'empleados') {
                form.action = "{{ route('reportes.empleados') }}";
            } else if (reporteNombre === 'servicios') { // Nueva opción para servicios
                form.action = "{{ route('reportes.servicios') }}";
            } else if (reporteNombre === 'proveedores') { // Nueva opción para proveedores
                form.action = "{{ route('reportes.proveedores') }}";
            } else if (reporteNombre === 'asignaciones') { // Nueva opción para asignaciones
                form.action = "{{ route('reportes.asignaciones') }}";
            } else {
                alert('Por favor ingrese un nombre de reporte válido ("Equipos", "Empleados", "Servicios", "Proveedores", "Asignaciones").');
                e.preventDefault(); // Evita el envío del formulario si no es válido
            }
        });
    </script>
@stop





