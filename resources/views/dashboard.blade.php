@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="flex justify-between items-center bg-gradient-to-r from-teal-500 to-blue-600 p-6 rounded-lg shadow-lg">
        <!-- Título Principal con un estilo moderno -->
        <div class="flex items-center space-x-4">
            <i class="fas fa-tachometer-alt text-white text-3xl"></i> <!-- Ícono atractivo del dashboard -->
            <h2 class="text-4xl font-bold text-white leading-tight">
                {{ __('Panel') }}
            </h2>
        </div>

    </div>
@stop

@section('content')

<x-app-layout>
  
     

    
                    <!-- Título principal -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-semibold text-gray-800">Bienvenido al Panel de Administración</h1>
                        <p class="mt-4 text-gray-600">Gestiona tu empresa de manera rápida y eficiente con nuestro panel de administración.</p>
                    </div>
                    
    <!-- Logo centrado -->
    <div class="flex justify-center mb-6">
        <x-application-logo class="block h-16 w-auto" />
    </div>

                    <!-- Cuadrados de información -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

                        <!-- Cuadro de Empleados -->
                        <div class="p-6 bg-indigo-100 border border-indigo-200 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <i class="fas fa-users fa-3x text-indigo-600"></i>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-indigo-800">Empleados</h2>
                                    <div class="flex items-center">
                                        <a href="{{ url('/empleados') }}" class="text-indigo-600 hover:underline">VER EMPLEADOS</a>
                                        <i class="fas fa-info-circle ml-2 text-indigo-600"></i> <!-- Ícono de More Info -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cuadro de Reportes -->
                        <div class="p-6 bg-green-100 border border-green-200 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt fa-3x text-green-600"></i>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-green-800">Reportes</h2>
                                    <div class="flex items-center">
                                        <a href="{{ url('/reportes') }}" class="text-green-600 hover:underline">VER REPORTES</a>
                                        <i class="fas fa-info-circle ml-2 text-green-600"></i> <!-- Ícono de More Info -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cuadro de Rutas de Asignaciones -->
                        <div class="p-6 bg-blue-100 border border-blue-200 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <i class="fas fa-route fa-3x text-blue-600"></i>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-blue-800">Asignaciones</h2>
                                    <div class="flex items-center">
                                        <a href="{{ url('/asignaciones') }}" class="text-blue-600 hover:underline">VER ASIGNACIONES</a>
                                        <i class="fas fa-info-circle ml-2 text-blue-600"></i> <!-- Ícono de More Info -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cuadro de Inventario -->
                        <div class="p-6 bg-yellow-100 border border-yellow-200 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <i class="fas fa-box-open fa-3x text-yellow-600"></i>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-yellow-800">Inventario</h2>
                                    <div class="flex items-center">
                                        <a href="{{ url('/equipos') }}" class="text-yellow-600 hover:underline">VER EQUIPOS</a>
                                        <i class="fas fa-info-circle ml-2 text-yellow-600"></i> <!-- Ícono de More Info -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cuadro de Servicios -->
                        <div class="p-6 bg-blue-100 border border-blue-300 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <i class="fas fa-cogs fa-3x text-blue-600"></i>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-blue-800">Servicios</h2>
                                    <div class="flex items-center">
                                        <a href="{{ url('/servicios') }}" class="text-blue-600 hover:underline">VER SERVICIOS</a>
                                        <i class="fas fa-info-circle ml-2 text-blue-600"></i> <!-- Ícono de More Info -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cuadro de Factura -->
                        <div class="p-6 bg-teal-100 border border-teal-300 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <div class="flex items-center">
                                <i class="fas fa-file-invoice fa-3x text-teal-600"></i>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-teal-800">Facturas</h2>
                                    <div class="flex items-center">
                                        <a href="{{ url('/facturas') }}" class="text-teal-600 hover:underline">VER FACTURAS</a>
                                        <i class="fas fa-info-circle ml-2 text-teal-600"></i> <!-- Ícono de More Info -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@stop

@section('css')
    <style>
        /* Fondo degradado en el Dashboard */
        body {
            background: linear-gradient(to right, #6EE7B7, #3B82F6);
        }

        /* Efectos de sombra y hover en los cuadros */
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        /* Mejorando el contorno y sombras en las tarjetas */
        .shadow-lg {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .transition {
            transition: all 0.3s ease-in-out;
        }

        .bg-teal-600:hover {
            background-color: #14B8A6;
        }

        /* Mejorar espaciados */
        .p-6 {
            padding: 24px;
        }

        .rounded-lg {
            border-radius: 8px;
        }

        .text-3xl {
            font-size: 2rem;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .font-semibold {
            font-weight: 600;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Dashboard cargado correctamente con todos los nuevos efectos visuales.");

        // Agregar interactividad aquí si es necesario
    </script>
@stop

