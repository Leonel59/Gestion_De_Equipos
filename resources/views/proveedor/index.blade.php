@extends('adminlte::page')

@section('title', 'Proveedores')

@section('css')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"> 
@stop

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Lista de Proveedores</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
@can('mantenimiento.ver')
    @can('mantenimiento.insertar') <!-- Verifica si el usuario puede insertar -->
        <div class="mb-3 text-center">
            <a href="{{ route('proveedores.create') }}" class="btn btn-outline-info text-center btn-block mb-4 rounded-pill">
                <span>Agregar Proveedor</span> <i class="fas fa-plus-square"></i>
            </a>
        </div>
    @endcan

    @if(session('success'))
        <div class="alert alert-success alert-dismissible mt-2 text-dark rounded-3" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-start align-items-center bg-gradient-primary text-white rounded-top">
            <h3 class="card-title mr-auto">Lista de Proveedores</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm mt-5">
                <table id="proveedoresTable" class="table table-striped table-bordered table-condensed table-hover rounded shadow-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RTN</th>
                            <th>Contacto</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            @canany(['mantenimiento.editar', 'mantenimiento.eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                                <th>Opciones</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                            <tr>
                                <td>{{ $proveedor->id_proveedor }}</td>
                                <td>{{ $proveedor->nombre_proveedor }}</td>
                                <td>{{ $proveedor->rtn_proveedor }}</td>
                                <td>{{ $proveedor->contacto_proveedor }}</td>
                                <td>{{ $proveedor->direccion_proveedor }}</td>
                                <td>{{ $proveedor->telefono_proveedor }}</td>
                                <td>{{ $proveedor->email_proveedor }}</td>
                                @canany(['mantenimiento.editar', 'mantenimiento.eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                                    <td class="text-center">
                                        @can('mantenimiento.editar') <!-- Verifica si el usuario puede editar -->
                                            <a href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}" class="btn btn-warning btn-sm rounded-pill" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('mantenimiento.eliminar') <!-- Verifica si el usuario puede eliminar -->
                                            <form action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @else
   <!-- Mensaje de permiso denegado -->
   <div class="card border-light shadow-sm mt-3 text-center">
        <div class="card-body">
            <i class="fas fa-lock text-danger mb-2" style="font-size: 2rem;"></i>
            <p class="mb-0" style="font-size: 1.1rem; color: #9e9e9e;">No tienes permiso para ver esta información.</p>
        </div>
    </div>
@endcan


@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#proveedoresTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger',
                    }, 
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success'
                    }
                ]
            });
        });
    </script>
@stop