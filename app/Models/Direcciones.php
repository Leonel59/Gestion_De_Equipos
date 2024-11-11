<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direcciones extends Model
{
    use HasFactory;

    protected $table = 'direcciones';
    protected $primaryKey = 'id_direcciones';
    public $timestamps = false;

    protected $fillable = [
        'cod_empleados',
        'departamento',
        'ciudad',
        'direccion'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cod_empleados', 'cod_empleados');
    }
}
