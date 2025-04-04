@extends('adminlte::page')

@section('title', 'Centro de Ayuda')

@section('content')
<div class="container">
        <div class="text-center mb-5 bg-primary text-white font-weight-bold py-3 rounded shadow-sm">
            <h2 style="font-size: 36px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                Centro de Ayuda
            </h2>
        </div>

        <div class="row justify-content-center">
            @can('seguridad.ver')
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Manual de Usuario</h4>
                            <p><i class="fas fa-file-pdf" style="font-size: 40px; color: #e74c3c;"></i></p>
                            <a href="{{ asset('storage/manuales/manual_usuario.pdf') }}" class="btn btn-primary" download>
                                Descargar <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

            @canany(['seguridad.insertar', 'seguridad.editar', 'seguridad.eliminar'])
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Manual Técnico</h4>
                            <p><i class="fas fa-file-pdf" style="font-size: 40px; color: #e74c3c;"></i></p>
                            <a href="{{ asset('storage/manuales/manual_tecnico.pdf') }}" class="btn btn-primary" download>
                                Descargar <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Manual de Acceso</h4>
                            <p><i class="fas fa-file-pdf" style="font-size: 40px; color: #e74c3c;"></i></p>
                            <a href="{{ asset('storage/manuales/manual_acceso.pdf') }}" class="btn btn-primary" download>
                                Descargar <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Manual de Instalación</h4>
                            <p><i class="fas fa-file-pdf" style="font-size: 40px; color: #e74c3c;"></i></p>
                            <a href="{{ asset('storage/manuales/manual_instalacion.pdf') }}" class="btn btn-primary" download>
                                Descargar <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endcanany
        </div>
    </div>

    <!-- Botón Regresar -->
    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Regresar al Dashboard
        </a>
    </div>
@endsection
