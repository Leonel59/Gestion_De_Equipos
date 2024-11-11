<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    use HasFactory;

    protected $table = 'sucursales'; // nombre de la tabla en la base de datos

    protected $fillable = [
        'nombre_sucursal',
    ];

    // Relación con el modelo Area
    public function areas()
    {
        return $this->hasMany(Areas::class, 'id_sucursal', 'id_sucursal'); // Define correctamente las columnas de relación
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cod_empleados', 'cod_empleados');
    }

}