<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory;

    // Permitir asignación masiva
    protected $fillable = ['name', 'guard_name'];

    // Relación con los objetos (módulos)
    public function objetos()
    {
        return $this->belongsToMany(Objeto::class, 'objetos_roles_permisos')
                    ->withPivot('ver', 'insertar', 'editar', 'eliminar')  // Los permisos asociados al objeto
                    ->withTimestamps();
    }
}
