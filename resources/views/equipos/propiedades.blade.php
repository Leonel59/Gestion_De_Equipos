@extends('adminlte::page')

@section('title', 'Propiedades del Equipo')

@section('content')
    <div class="container mt-4"> <!-- Agrega un contenedor con margen superior -->
        <div class="card mx-auto" style="max-width: 800px;"> <!-- Limita el ancho de la tarjeta y la centra -->
            <div class="card-body">
                @if($equipo->tipo_equipo === 'Computadora')
                    <h5>Propiedades de Computadora:</h5>
                    @if($equipo->propiedades_computadoras->isNotEmpty())
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Serie Cargador</th>
                                    <th>Procesador</th>
                                    <th>Memoria</th>
                                    <th>Tarjeta Gráfica</th>
                                    <th>Tipo de Disco</th>
                                    <th>Sistema Operativo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipo->propiedades_computadoras as $propiedad)
                                    <tr>
                                        <td>{{ $propiedad->serie_cargador_comp }}</td>
                                        <td>{{ $propiedad->procesador_comp }}</td>
                                        <td>{{ $propiedad->memoria_comp }}</td>
                                        <td>{{ $propiedad->tarjeta_grafica_comp }}</td>
                                        <td>{{ $propiedad->tipodisco_comp }}</td>
                                        <td>{{ $propiedad->sistema_operativo_comp }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay propiedades para esta computadora.</p>
                    @endif
                @elseif($equipo->tipo_equipo === 'Impresora')
                    <h5>Propiedades de Impresora:</h5>
                    @if($equipo->propiedades_impresoras->isNotEmpty())
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Tipo de Impresora</th>
                                    <th>Resolución</th>
                                    <th>Conectividad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipo->propiedades_impresoras as $propiedad)
                                    <tr>
                                        <td>{{ $propiedad->tipo_impresora }}</td>
                                        <td>{{ $propiedad->resolucion_impresora }}</td>
                                        <td>{{ $propiedad->conectividad_impresora }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay propiedades para esta impresora.</p>
                    @endif
                @elseif($equipo->tipo_equipo === 'Otro')
                    <h5>Otras Propiedades:</h5>
                    @if($equipo->propiedades_otroequipo->isNotEmpty())
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Capacidad</th>
                                    <th>Tamaño</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipo->propiedades_otroequipo as $propiedad)
                                    <tr>
                                        <td>{{ $propiedad->capacidad }}</td>
                                        <td>{{ $propiedad->tamano }}</td>
                                        <td>{{ $propiedad->color }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay propiedades para este otro equipo.</p>
                    @endif
                @else
                    <p>No se encontraron propiedades para este tipo de equipo.</p>
                @endif

                <!-- Botón para regresar -->
                <div class="mt-4 text-center">
                    <a href="{{ route('equipos.index') }}" class="btn btn-primary">Regresar</a>
                </div>
            </div>
        </div>
    </div>
@stop
