@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Lista de Proveedores</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('proveedores.create') }}" class="btn btn-success">Agregar Proveedor</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="proveedoresTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RTN</th>
                        <th>Contacto</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Acciones</th>
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
                            <td>
                                <a href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            $('#proveedoresTable').DataTable();
        });
    </script>
@stop
