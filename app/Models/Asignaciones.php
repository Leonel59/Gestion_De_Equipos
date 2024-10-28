<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    use HasFactory;

    protected $table = 'asignaciones'; // Especifica la tabla si el nombre no sigue la convención

    protected $primaryKey = 'id_asignacion'; // Especifica la clave primaria

    public $timestamps = true; // Indica que se utilizan created_at y updated_at

    protected $fillable = [
        'cod_empleados',
        'sucursal', // Asegúrate de incluir 'sucursal' en los fillable
        'detalle_asignacion',
        'fecha_asignacion',
        'fecha_devolucion',
        
    ];

    // Definición de relaciones

    /**
     * Relación con el modelo Empleados.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cod_empleados', 'cod_empleado');
    }

}
