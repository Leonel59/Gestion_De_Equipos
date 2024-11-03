@extends('adminlte::page')

@section('title', 'Bitácora')

@section('content_header')
    <h1>Bitácora</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
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
                            <a href="{{ route('bitacoras.download', $bitacora->id) }}" class="btn btn-info btn-sm">Descargar</a>
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

@stop

@section('css')
<style>
    .minimal-pagination {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .minimal-pagination li {
        margin: 0 5px; /* Espaciado entre los elementos */
    }
    
    .minimal-pagination a, .minimal-pagination span {
        display: inline-block;
        padding: 8px 12px; /* Espaciado interno */
        color: #007bff; /* Color de texto */
        text-decoration: none; /* Sin subrayado */
        border-radius: 4px; /* Bordes redondeados */
        transition: background-color 0.3s; /* Efecto de transición */
    }

    .minimal-pagination li.active span {
        background-color: #007bff; /* Fondo de la página activa */
        color: white; /* Color del texto en la página activa */
    }

    .minimal-pagination a:hover {
        background-color: rgba(0, 123, 255, 0.1); /* Fondo en hover */
    }

    .minimal-pagination li.disabled span {
        color: #ccc; /* Color de texto deshabilitado */
    }
</style>
@stop