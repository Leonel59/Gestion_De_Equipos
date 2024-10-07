@extends('adminlte::page')



@section('css')
<!-- <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('title', 'Parametro')
@section('content_header')
    <h1 class="text-center">Parametro</h1>
    <hr class="bg-dark border-1 border-top border-dark">
@stop

@section('content')

<a href="{{route('parametros.create')}}"
    class="btn btn-outline-info text-center btn-block">
<span>Crear Nuevo Parametro</span> <i class="fas fa-plus-square"></i>
</a>

@if (session('info'))
<div class="alert alert-success alert-dismissible mt-2 tex-dark" role="alert>
<span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
<strong>{{session('info')}}</strong>
</div>
@endif

<div class="table-responsive-sm mt-5">
    <table id="tablaParametros" class="table table-striped table-bordered table-condensed table-hover">
<thead class="thead-dark">
    <tr>
<th>#</th>
<th>Parametro</th>
<th>Valor</th>
<th>Opciones</th>
    </tr>
</thead>
<tbody>

@php $i=1;@endphp

@foreach($parametros as $i => $parametro)
    <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $parametro->parametro }}</td>
        <td>{{ $parametro->valor }}</td>
        <td class="text-center">
   
        <a href="{{route('parametros.edit',$parametro->id)}}"
        class="btn btn-warning btm-sm fa fa-edit">
        </a>
    </tr>

</td>
</tr>

@php $i++;@endphp
@endforeach

</tbody>
@stop

@section('css')

@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaParametros').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            dom: 'Blfrtip',
            // dom: '<"pt-2 row" <"col-xl mt-2"l><"col-xl text-center"B><"col-xl text-right mt-2 buscar"f>> <"row"rti<"col"><p>>',
            buttons: [
                {
                    extend: 'pdf',
                    className: 'btn btn-danger glyphicon glyphicon-duplicate',
                   
                }, 
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-secondary glyphicon glyphicon-duplicate'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success glyphicon glyphicon-duplicate'
                }
            ]
        });
    });
</script>
</script>
@stop


