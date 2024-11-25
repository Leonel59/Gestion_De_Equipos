@extends('adminlte::page')

@section('title', 'Editar Equipo')

@section('content_header')
<h1>Editar Equipo</h1>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Modificar Datos del Equipo</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('equipos.update', $equipo->id_equipo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cod_equipo">Código Equipo</label>
                                <input type="text" class="form-control" id="cod_equipo" name="cod_equipo"
                                    value="{{ old('cod_equipo', $equipo->cod_equipo) }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="estado_equipo">Estado</label>
                                <select class="form-control" id="estado_equipo" name="estado_equipo" required>
                                    <option value="Disponible" {{ $equipo->estado_equipo == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="En Mantenimiento" {{ $equipo->estado_equipo == 'En Mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                    <option value="Comodin" {{ $equipo->estado_equipo == 'Comodin' ? 'selected' : '' }}>Comodin</option>
                                    <option value="Asignado" {{ $equipo->estado_equipo == 'Asignado' ? 'selected' : '' }}>Asignado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tipo_equipo">Tipo de Equipo</label>
                                <select class="form-control" id="tipo_equipo" name="tipo_equipo" required>
                                    <option value="Computadora" {{ $equipo->tipo_equipo == 'Computadora' ? 'selected' : '' }}>Computadora</option>
                                    <option value="Impresora" {{ $equipo->tipo_equipo == 'Impresora' ? 'selected' : '' }}>Impresora</option>
                                    <option value="Otro" {{ $equipo->tipo_equipo == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marca_equipo">Marca Equipo</label>
                                <input type="text" class="form-control" id="marca_equipo" name="marca_equipo" value="{{ old('marca_equipo', $equipo->marca_equipo) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="modelo_equipo">Modelo Equipo</label>
                                <input type="text" class="form-control" id="modelo_equipo" name="modelo_equipo" value="{{ old('modelo_equipo', $equipo->modelo_equipo) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="numero_serie">Número de Serie</label>
                                <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="{{ old('numero_serie', $equipo->numero_serie) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="precio_equipo">Precio Equipo</label>
                                <div class="input-group">
                                    <span class="input-group-text">L.</span>
                                    <input type="number" class="form-control" id="precio_equipo" name="precio_equipo" step="0.01" value="{{ old('precio_equipo', $equipo->precio_equipo) }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion"
                                    value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion) }}" required>
                                <small id="fechaWarning" class="text-danger" style="display: none;">No puede ser mayor a la fecha actual.</small>
                                <span id="mensaje_fecha" class="text-danger" style="display: none;"></span>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <!-- Campos específicos para Computadora -->
                            <div id="camposComputadora" @if($equipo->tipo_equipo == 'Computadora') style="display: block;" @else style="display: none;" @endif>
                                <h5>Propiedades de Computadora</h5>
                                <div class="form-group">
                                    <label for="serie_cargador_comp">Serie Cargador</label>
                                    <input type="text" class="form-control" name="serie_cargador_comp" value="{{ old('serie_cargador_comp', $equipo->propiedades_computadoras->first()->serie_cargador_comp ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="procesador_comp">Procesador</label>
                                    <input type="text" class="form-control" name="procesador_comp" value="{{ old('procesador_comp', $equipo->propiedades_computadoras->first()->procesador_comp ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="memoria_comp">Memoria</label>
                                    <input type="text" class="form-control" name="memoria_comp" value="{{ old('memoria_comp', $equipo->propiedades_computadoras->first()->memoria_comp ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tarjeta_grafica_comp">Tarjeta Gráfica (Opcional)</label>
                                    <input type="text" class="form-control" name="tarjeta_grafica_comp" value="{{ old('tarjeta_grafica_comp', $equipo->propiedades_computadoras->first()->tarjeta_grafica_comp ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tipodisco_comp">Tipo de Disco</label>
                                    <input type="text" class="form-control" name="tipodisco_comp" value="{{ old('tipodisco_comp', $equipo->propiedades_computadoras->first()->tipodisco_comp ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="sistema_operativo_comp">Sistema Operativo</label>
                                    <input type="text" class="form-control" name="sistema_operativo_comp" value="{{ old('sistema_operativo_comp', $equipo->propiedades_computadoras->first()->sistema_operativo_comp ?? '') }}">
                                </div>
                            </div>

                            <!-- Campos específicos para Impresora -->
                            <div id="camposImpresora" @if($equipo->tipo_equipo == 'Impresora') style="display: block;" @else style="display: none;" @endif>
                                <h5>Propiedades de Impresora</h5>
                                <div class="form-group">
                                    <label for="tipo_impresora">Tipo de Impresora</label>
                                    <input type="text" class="form-control" name="tipo_impresora" value="{{ old('tipo_impresora', $equipo->propiedades_impresoras->first()->tipo_impresora ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="resolucion_impresora">Resolución</label>
                                    <input type="text" class="form-control" name="resolucion_impresora" value="{{ old('resolucion_impresora', $equipo->propiedades_impresoras->first()->resolucion_impresora ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="conectividad_impresora">Conectividad</label>
                                    <input type="text" class="form-control" name="conectividad_impresora" value="{{ old('conectividad_impresora', $equipo->propiedades_impresoras->first()->conectividad_impresora ?? '') }}">
                                </div>
                            </div>

                            <!-- Campos específicos para Otro Equipo -->
                            <div id="camposOtro" @if($equipo->tipo_equipo == 'Otro') style="display: block;" @else style="display: none;" @endif>
                                <h5>Propiedades de Otro Equipo</h5>
                                <div class="form-group">
                                    <label for="capacidad">Capacidad</label>
                                    <input type="text" class="form-control" name="capacidad" value="{{ old('capacidad', $equipo->propiedades_otroequipo->first()->capacidad ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tamano">Tamaño</label>
                                    <input type="text" class="form-control" name="tamano" value="{{ old('tamano', $equipo->propiedades_otroequipo->first()->tamano ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" class="form-control" name="color" value="{{ old('color', $equipo->propiedades_otroequipo->first()->color ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para manejar la visualización de campos dependiendo del tipo de equipo
    document.getElementById('tipo_equipo').addEventListener('change', function() {
        var tipoEquipo = this.value;
        document.getElementById('camposComputadora').style.display = (tipoEquipo === 'Computadora') ? 'block' : 'none';
        document.getElementById('camposImpresora').style.display = (tipoEquipo === 'Impresora') ? 'block' : 'none';
        document.getElementById('camposOtro').style.display = (tipoEquipo === 'Otro') ? 'block' : 'none';
    });

    // Validación para el campo marca, tipo impresora y color
    document.querySelectorAll('input[name="marca_equipo"], input[name="tipo_impresora"], input[name="color"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); // Solo permite letras
        });
    });

    // Validaciones en tiempo real para campos modelo, numero serie, serie cargador
    document.querySelectorAll('input[name="modelo_equipo"], input[name="numero_serie"], input[name="serie_cargador_comp"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); // Solo permite letras y números
        });
    });

    // Validación para el campo de memoria, procesador y tarjeta grafica
    document.querySelectorAll('input[name="memoria_comp"], input[name="procesador_comp"], input[name="tarjeta_grafica_comp"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); // Solo permite letras y números
        });
    });

    // Validación para el campo tipo disco y sistema operativo
    document.querySelectorAll('input[name="tipodisco_comp"], input[name="sistema_operativo_comp"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); // Solo permite letras y números
        });
    });

    // Validación para el campo de conectividad de impresora
    document.querySelector('input[name="conectividad_impresora"]').addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-Z,\s]/g, ''); // Permite letras y comas
    });

    // Validación para el campo de resolución impresora
    document.querySelector('input[name="resolucion_impresora"]').addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); // Permite letras, números y espacios
    });

    // Validación para los campos de capacidad y tamaño
    document.querySelectorAll('input[name="tamano"], input[name="capacidad"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); // Solo permite letras y números
        });
    });

    // Validacion para la fecha de adquisicion
    document.getElementById('fecha_adquisicion').addEventListener('input', function() {
        var fechaSeleccionada = new Date(this.value);
        var fechaActual = new Date();

        // Ajustar la fecha actual a solo la fecha (sin hora)
        fechaActual.setHours(0, 0, 0, 0);

        // Comprobar si la fecha seleccionada es mayor a la fecha actual
        if (fechaSeleccionada > fechaActual) {
            document.getElementById('fechaWarning').style.display = 'block'; // Mostrar advertencia
            this.value = ''; // Limpiar el campo de fecha
        } else {
            document.getElementById('fechaWarning').style.display = 'none'; // Ocultar advertencia
        }
    });



    document.addEventListener('DOMContentLoaded', function() {
        const tipoEquipoField = document.getElementById('tipo_equipo');
        tipoEquipoField.addEventListener('change', function() {
            // Limpiar los campos comunes
            document.getElementById('estado_equipo').value = '';
            document.getElementById('marca_equipo').value = '';
            document.getElementById('modelo_equipo').value = '';
            document.getElementById('numero_serie').value = '';
            document.getElementById('precio_equipo').value = '';
            document.getElementById('fecha_adquisicion').value = '';
        });
    });
</script>

@endsection
