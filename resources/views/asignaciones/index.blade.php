@extends('adminlte::page')

@section('title', 'Asignaciones')

@section('content_header')
    <h1>Lista de Asignaciones</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('asignaciones.create') }}" class="btn btn-success">Agregar Asignación</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="asignacionesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Asignación</th>
                        <th>Empleado</th>
                        <th>Sucursal</th>
                        <th>Detalle de Asignación</th>
                        <th>Fecha de Asignación</th>
                        <th>Fecha de Devolución</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaciones as $asignacion)
                        <tr>
                            <td>{{ $asignacion->id_asignacion }}</td>
                            <td>{{ $asignacion->empleado->cod_empleado }}</td>
                            <td>{{ $asignacion->sucursal }}</td>
                            <td>{{ $asignacion->detalle_asignacion }}</td>
                            <td>{{ $asignacion->fecha_asignacion ? \Carbon\Carbon::parse($asignacion->fecha_asignacion)->format('d-m-Y') : 'N/A' }}</td>
                            <td>{{ $asignacion->fecha_devolucion ? \Carbon\Carbon::parse($asignacion->fecha_devolucion)->format('d-m-Y') : 'N/A' }}</td>

                            <td>
                                <a href="{{ route('asignaciones.edit', $asignacion->id_asignacion) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('asignaciones.destroy', $asignacion->id_asignacion) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta asignación?')">Eliminar</button>
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
            $('#asignacionesTable').DataTable();
        });
    </script>
@stop
