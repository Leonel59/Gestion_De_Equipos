@extends('adminlte::page')

@section('title', 'Editar Objeto')

@section('content_header')
<h1 class="title text-center">Editar Interfaces</h1>
@stop

@section('content')

<div class="card shadow-sm">
    <div class="card-body justify-content-center">
        <form action="{{ route('objetos.update', $objeto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Selección de Roles y Permisos -->
            <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-md-10">

                    <div class="form-group mt-4">
                        <label for="roles">Roles y Permisos</label>
                        <div class="row d-flex flex-wrap">
                            @foreach ($roles as $role)
                            @if(in_array($role->id, $objeto->roles->pluck('id')->toArray()))
                            <div class="col-md-6 mb-4">
                                <div class="role-box p-3 border rounded shadow-sm">
                                    <div class="role-title text-center mb-3">
                                        <input type="checkbox" name="roles[{{ $role->id }}][id]" value="{{ $role->id }}" 
                                            class="role-checkbox" id="role{{ $role->id }}" checked>
                                        <label for="role{{ $role->id }}">
                                            <span class="badge badge-primary p-2">
                                                <i class="fas fa-user-shield"></i> {{ $role->name }}
                                            </span>
                                        </label>
                                    </div>

                                    <!-- Permisos del rol -->
                                    <div class="permissions p-2 border rounded" id="permissions{{ $role->id }}">
                                        @foreach ($rutas as $route => $label)
                                        <div class="permission-box mb-3">
                                            <div class="permission-header bg-light text-dark p-2 rounded">
                                                <strong>{{ $label }}</strong>
                                            </div>
                                            <div class="permission-options d-flex justify-content-around mt-2">
                                                @foreach (["ver", "insertar", "editar", "eliminar"] as $action)
                                                <div class="form-check">
                                                    <input type="checkbox" name="roles[{{ $role->id }}][permisos][{{ $route }}][{{ $action }}]"
                                                        value="1" class="form-check-input"
                                                        id="{{ $action }}-{{ $role->id }}-{{ $route }}"
                                                        @if(isset($rolePermissions[$role->id][$route][$action]) && 
                                                        $rolePermissions[$role->id][$route][$action]) checked @endif>
                                                    <label class="form-check-label small" for="{{ $action }}-{{ $role->id }}-{{ $route }}">
                                                        {{ ucfirst($action) }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="form-group mt-4 text-right">
                        <a href="{{ route('objetos.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

@stop

@push('css')
<style>
    /* Diseño de los permisos */
    .permissions {
        background-color: #f8f9fa;
    }

    .permission-box {
        border: 1px solid #dee2e6;
        padding: 10px;
        border-radius: 8px;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .permission-header {
        font-weight: bold;
        text-align: center;
    }

    .permission-options .form-check {
        text-align: center;
        margin: 0 5px;
    }

    .role-title input[type="checkbox"] {
        margin-right: 8px;
    }
</style>
@endpush

@push('js')
<script>
    // Alternar visibilidad de los permisos según el estado del rol
    document.querySelectorAll('.role-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const roleId = this.id.replace('role', '');
            const permissionsDiv = document.getElementById('permissions' + roleId);
            permissionsDiv.style.display = this.checked ? 'block' : 'none';
        });
    });
</script>
@endpush






