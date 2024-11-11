<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefonos extends Model
{
    use HasFactory;

    protected $table = 'telefonos';
    protected $primaryKey = 'id_telefono';
    public $timestamps = false;

    protected $fillable = [
        'cod_empleados',
        'telefono_personal',
        'telefono_trabajo'
    ];
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cod_empleados', 'cod_empleados');
    }

}