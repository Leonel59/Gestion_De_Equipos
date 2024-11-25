@extends('adminlte::page')

@section('title', 'Suministros')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Lista de Suministros</h1>
@stop

@section('content')
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-start align-items-center bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mr-auto">Suministros Registrados</h3>
            @can('insertar')
                <a href="{{ route('suministros.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus"></i> Agregar Suministro
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if ($message = Session::get('mensaje'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table id="suministrosTable" class="table table-striped table-hover rounded shadow-sm">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Proveedor</th>
                        <th>Nombre del Suministro</th>
                        <th>Descripción</th>
                        <th>Fecha de Adquisición</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Costo Total</th>
                        @canany(['editar', 'eliminar'])
                            <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suministros as $suministro)
                        <tr class="text-center">
                            <td>{{ $suministro->proveedor->nombre_proveedor ?? 'Sin Proveedor' }}</td>
                            <td>{{ $suministro->nombre_suministro }}</td>
                            <td>{{ $suministro->descripcion_suministro }}</td>
                            <td>{{ $suministro->fecha_adquisicion ? \Carbon\Carbon::parse($suministro->fecha_adquisicion)->format('d-m-Y') : 'N/A' }}</td>
                            <td>{{ $suministro->cantidad_suministro }}</td>
                            <td>L.{{ number_format($suministro->costo_unitario, 2) }}</td>
                            <td>L.{{ number_format($suministro->costo_total, 2) }}</td>
                            @canany(['editar', 'eliminar'])
                                <td>
                                    @can('editar')
                                        <a href="{{ route('suministros.edit', $suministro->id_suministro) }}" class="btn btn-warning btn-sm rounded-pill">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    @endcan
                                    @can('eliminar')
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill delete-suministro" data-id="{{ $suministro->id_suministro }}">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    @endcan
                                </td>
                            @endcanany
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .card {
            border-radius: 15px;
        }
        .table th, .table td {
            padding: 10px;
        }
        .btn-lg {
            border-radius: 30px;
            font-size: 1.1rem;
        }
        .btn-sm {
            border-radius: 20px;
        }
        .alert {
            border-radius: 10px;
        }
        .dataTables_paginate {
            float: none; /* Centra los botones de paginación */
            text-align: center;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#suministrosTable').DataTable({
                searching: true,
                ordering: false,
                paging: true,
                info: true,
                language: {
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    },
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)"
                }
            });

            $(document).on('click', '.delete-suministro', function() {
                var suministroId = $(this).data('id');
                var url = '{{ route("suministros.destroy", ":id") }}'.replace(':id', suministroId);

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás recuperar este suministro!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminarlo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado!',
                                    'El suministro ha sido eliminado.',
                                    'success'
                                );
                                location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'No se pudo eliminar el suministro.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
