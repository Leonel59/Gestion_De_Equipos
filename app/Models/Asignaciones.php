<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_equipo',
        'id_sucursal',
        'id_area',
        'cod_empleados',
        'detalle_asignacion',
        'fecha_asignacion',
        'fecha_devolucion'
    ];

    protected $table = 'asignaciones'; // Nombre de la tabla
    protected $primaryKey = 'id_asignacion'; // Clave primaria
    public $timestamps = true; // Esto es opcional, según tu configuración

    // Relación con el modelo Equipos
    public function equipos()
    {
        return $this->belongsTo(Equipos::class, 'id_equipo', 'id_equipo');
    }

    // Relación con el modelo Sucursales
    public function sucursales()
    {
        return $this->belongsTo(Sucursales::class, 'id_sucursal', 'id_sucursal');
    }

    // Relación con el modelo Empleados
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cod_empleados', 'cod_empleados');
    }

    // Relación con el modelo Áreas
    public function areas()
    {
        return $this->belongsTo(Areas::class, 'id_area', 'id_area');
    }


    
    public function suministros()
    {
        return $this->belongsToMany(Suministros::class, 'asignacion_suministros', 'id_asignacion', 'id_suministro');
    }
    
    
}
