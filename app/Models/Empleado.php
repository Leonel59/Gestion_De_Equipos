<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod_empleado',
        'correo',
        'telefono',
        'direccion',
        'sucursal',
        'area',
        'dni_empleado',
        'nombre_empleado',
        'apellido_empleado',
        'cargo_empleado',
        'fecha_contratacion',
        'sexo_empleado',
    ];
}
