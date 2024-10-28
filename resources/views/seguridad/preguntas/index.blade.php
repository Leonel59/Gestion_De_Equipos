@extends('adminlte::page')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn {
        transition: background-color 0.3s, transform 0.3s;
    }
    .btn:hover {
        transform: scale(1.05);
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    .btn-success {
        background-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .btn-warning {
        background-color: #ffc107;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
</style>
@stop

@section('title', 'Preguntas')

@section('content_header')
<h1 class="text-center">Preguntas de Seguridad</h1>
<hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

<a href="{{route('preguntas.create')}}" class="btn btn-outline-info text-center btn-block">
    <span>Crear Nueva Pregunta</span> <i class="fas fa-plus-square"></i>
</a>

@if (session('info'))
<div class="alert alert-success alert-dismissible mt-2 text-dark" role="alert">
    <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
    <strong>{{session('info')}}</strong>
</div>
@endif

<div class="table-responsive-sm mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h3 class="card-title">Lista de Preguntas</h3>
        </div>
        <div class="card-body">
            <table id="tablaPreguntas" class="table table-striped table-bordered table-condensed table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Pregunta</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($preguntas as $i => $pregunta)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>¿{{ $pregunta->pregunta }}?</td>
                    <td class="text-center">
                        <form action="{{route('preguntas.destroy', $pregunta->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{route('preguntas.edit', $pregunta->id)}}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tablaPreguntas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    className: 'btn btn-danger',
                    text: 'Exportar a PDF'
                }, 
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success',
                    text: 'Exportar a Excel'
                }
            ]
        });
    });
</script>
@stop
