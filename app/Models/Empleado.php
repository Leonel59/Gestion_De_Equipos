<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'cod_empleados';
    public $timestamps = false; // Si no usas los campos created_at y updated_at

    protected $fillable = [
        'cod_empleados',
        'id_sucursal',
        'id_area',
        'nombre_empleado',
        'apellido_empleado',
        'cargo_empleado',
        'estado_empleado',
        'fecha_contratacion',
        'fecha_modificacion'
    ];



    public function correos()
    {
        return $this->hasMany(Correos::class, 'cod_empleados', 'cod_empleados');
    }
    

    public function telefonos()
    {
        return $this->hasMany(Telefonos::class, 'cod_empleados', 'cod_empleados');
    }

    public function direcciones()
    {
        return $this->hasMany(Direcciones::class, 'cod_empleados', 'cod_empleados');
    }


    public function sucursales()
{
    return $this->belongsTo(Sucursales::class, 'id_sucursal', 'id_sucursal');
}


public function areas()
{
    return $this->belongsTo(Areas::class, 'id_area', 'id_area');
}
}