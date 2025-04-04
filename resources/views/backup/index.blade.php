@extends('adminlte::page')

@section('css')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet"> 
@stop

@section('title', 'Gestión de Puntos de Restauración')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">Gestión de Puntos de Restauración</h1>
@stop

@section('content')
@can('seguridad.ver')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white rounded-top">
        <h3 class="card-title">Lista de Respaldos</h3>
        @can('seguridad.insertar') 
            <div class="ml-auto">
                <button type="button" class="btn btn-success font-weight-bold" id="createBackupBtn">
                    <i class="fas fa-save"></i> Crear Nuevo Respaldo
                </button>
                <form id="createBackupForm" action="{{ route('backup.create') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @endcan
    </div>

    <div class="card-body">
        {{-- Notificación de éxito o error con SweetAlert --}}
        @if(session('info'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "{{ session('info') }}",
                        icon: "success",
                        confirmButtonText: 'Aceptar',
                        timer: 3000
                    });
                });
            </script>
        @endif

        <div class="table-responsive-sm mt-3">
            <table id="tablaBackups" class="table table-striped table-bordered table-hover rounded shadow-sm">
                <thead class="thead-light">
                    <tr>
                        <th><i class="fas fa-file-alt"></i> Archivo</th>
                        @canany(['seguridad.editar', 'seguridad.eliminar'])
                            <th class="text-center"><i class="fas fa-cogs"></i> Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($backups as $backup)
                        <tr>
                            <td>
                                <i class="fas fa-database text-info"></i> {{ basename($backup) }}
                            </td>
                            @canany(['seguridad.editar', 'seguridad.eliminar'])
                                <td class="text-center">
                                    @can('seguridad.editar')
                                        <button type="button" class="btn btn-primary btn-sm restore-backup" data-backup="{{ basename($backup) }}">
                                            <i class="fas fa-undo-alt"></i> Restaurar
                                        </button>
                                    @endcan
                                    @can('seguridad.eliminar')
                                        <button type="button" class="btn btn-danger btn-sm delete-backup" data-backup="{{ basename($backup) }}">
                                            <i class="fas fa-trash-alt"></i> Eliminar
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
</div>

@else
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#tablaBackups').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
            
        });

        // Crear punto de restauración con SweetAlert
        document.getElementById('createBackupBtn')?.addEventListener('click', function() {
            Swal.fire({
                title: "¿Crear un nuevo punto de restauración?",
                text: "Se generará un respaldo de la base de datos.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Sí, crear",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createBackupForm').submit();
                }
            });
        });

        // Restaurar punto de restauración con SweetAlert
        document.querySelectorAll('.restore-backup').forEach(button => {
            button.addEventListener('click', function() {
                let backupFile = this.getAttribute('data-backup');

                Swal.fire({
                    title: "¿Restaurar este punto?",
                    text: "Se sobrescribirá la base de datos actual con el respaldo seleccionado.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, restaurar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.method = "POST";
                        form.action = "{{ route('backup.restore') }}";
                        form.innerHTML = `@csrf <input type="hidden" name="backup_file" value="${backupFile}">`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

        // Eliminar punto de restauración con SweetAlert
        document.querySelectorAll('.delete-backup').forEach(button => {
            button.addEventListener('click', function() {
                let backupFile = this.getAttribute('data-backup');

                Swal.fire({
                    title: "¿Eliminar este punto de restauración?",
                    text: "Esta acción no se puede deshacer.",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.method = "POST";
                        form.action = "{{ route('backup.destroy') }}";
                        form.innerHTML = `@csrf <input type="hidden" name="backup_file" value="${backupFile}">`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@stop


