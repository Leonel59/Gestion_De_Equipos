@extends('adminlte::page')

@section('title', 'Proveedores')

@section('css')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"> 
@stop

@section('content_header')
    <h1 class="text-center">Lista de Proveedores</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')
    @can('insertar') <!-- Verifica si el usuario puede insertar -->
        <div class="mb-3 text-center">
            <a href="{{ route('proveedores.create') }}" class="btn btn-outline-info">
                <span>Agregar Proveedor</span> <i class="fas fa-plus-square"></i>
            </a>
        </div>
    @endcan

    @if(session('success'))
        <div class="alert alert-success alert-dismissible mt-2" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="table-responsive-sm mt-5">
        <table id="proveedoresTable" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>RTN</th>
                    <th>Contacto</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
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
                        @canany(['editar', 'eliminar']) <!-- Verifica si el usuario puede editar o eliminar -->
                            <td class="text-center">
                                @can('editar') <!-- Verifica si el usuario puede editar -->
                                    <a href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('eliminar') <!-- Verifica si el usuario puede eliminar -->
                                    <form action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                            <i class="fa fa-trash"></i>
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
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
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
