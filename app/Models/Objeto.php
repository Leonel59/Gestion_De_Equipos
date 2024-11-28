<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objeto extends Model
{
    use HasFactory;

    // Especificar la tabla si es necesario (aunque Laravel asume el plural automáticamente)
    protected $table = 'objetos';

    // Los campos que pueden ser asignados de forma masiva
    protected $fillable = [
        'name',  // Cambié 'objeto' a 'name' según tu migración
    ];

    // Definir la relación con la tabla 'roles'
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'objetos_roles_permisos')
                    ->withPivot('ver', 'insertar', 'editar', 'eliminar')  // Los permisos asociados al rol
                    ->withTimestamps();
    }

    // Opcional: relación con los permisos directamente si los deseas manejar
    public function permisos()
    {
        return $this->belongsToMany(Permission::class, 'objetos_roles_permisos', 'objeto_id', 'role_id')
                    ->withPivot('ver', 'insertar', 'editar', 'eliminar')  // Los permisos asociados a este objeto
                    ->withTimestamps();
    }
}
