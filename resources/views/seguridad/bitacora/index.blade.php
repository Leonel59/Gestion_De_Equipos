@extends('adminlte::page')

@section('title', 'Bitácora')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark font-weight-bold" style="font-size: 28px; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);">
            <i class="fas fa-book"></i> Bitácora
        </h1>
        <input type="text" id="search" class="form-control w-25" placeholder="Buscar...">
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Permiso general para acceder a la bitácora -->
        @can('seguridad.ver')
        <h2 class="text-dark font-weight-bold" style="font-size: 24px; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);">
    <i class="fas fa-tasks"></i> Gestión de Bitácora
</h2>
<hr class="mb-4">



            <!-- Sólo mostrar tabla si se tiene permiso para ver -->
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Tabla</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                        <th>Valores Anteriores</th>
                        <th>Valores Nuevos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bitacoras as $bitacora)
                        <tr>
                            <td>{{ $bitacora->fecha }}</td>
                            <td>{{ $bitacora->usuario ? $bitacora->usuario->name : 'Usuario no disponible' }}</td>
                            <td>{{ $bitacora->tabla }}</td>
                            <td>{{ $bitacora->accion }}</td>
                            <td>{{ Str::limit($bitacora->descripcion, 50) }} <a href="#" data-toggle="modal" data-target="#modal{{ $bitacora->id }}">Ver más</a></td>
                            <td>{{ Str::limit($bitacora->valores_anteriores, 50) }} <a href="#" data-toggle="modal" data-target="#modalAnterior{{ $bitacora->id }}">Ver más</a></td>
                            <td>{{ Str::limit($bitacora->valores_nuevos, 50) }} <a href="#" data-toggle="modal" data-target="#modalNuevo{{ $bitacora->id }}">Ver más</a></td>
                            <td>
                                <!-- Mostrar botón de descarga solo si se tiene permiso para ver -->
                                @can('seguridad.ver')
                                    <a href="{{ route('bitacoras.download', $bitacora->id) }}" class="btn btn-info btn-sm">Descargar</a>
                                @endcan
                            </td>
                        </tr>

                        <!-- Modal para Descripción -->
                        <div class="modal fade" id="modal{{ $bitacora->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Descripción Completa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $bitacora->descripcion }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Valores Anteriores -->
                        <div class="modal fade" id="modalAnterior{{ $bitacora->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Valores Anteriores</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            @php
                                                $valoresAnteriores = json_decode($bitacora->valores_anteriores, true) ?? [];
                                            @endphp
                                            @if (count($valoresAnteriores) > 0)
                                                @foreach ($valoresAnteriores as $key => $valor)
                                                    <li>{{ $key }}: {{ $valor }}</li>
                                                @endforeach
                                            @else
                                                <li>No hay valores anteriores disponibles.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Valores Nuevos -->
                        <div class="modal fade" id="modalNuevo{{ $bitacora->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Valores Nuevos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            @php
                                                $valoresNuevos = json_decode($bitacora->valores_nuevos, true) ?? [];
                                            @endphp
                                            @if (count($valoresNuevos) > 0)
                                                @foreach ($valoresNuevos as $key => $valor)
                                                    <li>{{ $key }}: {{ $valor }}</li>
                                                @endforeach
                                            @else
                                                <li>No hay valores nuevos disponibles.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation">
            <ul class="pagination minimal-pagination">
                @if ($bitacoras->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                @else
                    <li><a href="{{ $bitacoras->previousPageUrl() }}">&laquo;</a></li>
                @endif

                @foreach ($bitacoras->getUrlRange(1, $bitacoras->lastPage()) as $page => $url)
                    @if ($page == $bitacoras->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($bitacoras->hasMorePages())
                    <li><a href="{{ $bitacoras->nextPageUrl() }}">&raquo;</a></li>
                @else
                    <li class="disabled"><span>&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>
@else
    <div class="card border-light shadow-sm mt-3 text-center">
        <div class="card-body">
            <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
            <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
        </div>
    </div>
@endcan

@stop

@section('css')
<style>
    /* Aseguramos que la tabla sea más compacta */
    .table-sm th, .table-sm td {
        padding: 6px; /* Espaciado más pequeño */
        font-size: 0.9rem; /* Tamaño de fuente más pequeño */
    }

    .minimal-pagination {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.9rem; /* Tamaño de fuente reducido para paginación */
    }

    .minimal-pagination li {
        margin: 0 5px;
    }

    .minimal-pagination a, .minimal-pagination span {
        padding: 6px 10px; /* Reducir el tamaño de los botones de paginación */
        color: #007bff;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .minimal-pagination li.active span {
        background-color: #007bff;
        color: white;
    }

    .minimal-pagination a:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .minimal-pagination li.disabled span {
        color: #ccc;
    }

    #search {
        border-radius: 20px;
        padding: 5px 15px;
        border: 1px solid #ccc;
    }
</style>

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let searchInput = document.getElementById("search");

        searchInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Evita que se envíe el formulario o recargue la página
                let filter = searchInput.value.toLowerCase();
                let rows = document.querySelectorAll("table tbody tr");

                rows.forEach(row => {
                    let rowText = row.innerText.toLowerCase();
                    if (rowText.includes(filter)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
        });
    });
</script>

@stop



