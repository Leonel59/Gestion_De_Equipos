<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoMantenimiento extends Model
{
    use HasFactory;

    protected $table = 'producto_mantenimiento';
    protected $primaryKey = 'id_producto';
    public $timestamps = true;

    protected $fillable = [
        'id_proveedor',
        'nombre_producto',
        'descripcion_producto',
        'cantidad_producto',
        'costo_producto',
        'fecha_adquisicion_producto',
        'servicio_mantenimiento_id', // Relacionado con ServicioMantenimiento
    ];

    /**
     * Relación con el modelo ServicioMantenimiento
     */
    public function servicioMantenimiento()
    {
        return $this->belongsTo(ServiciosMantenimientos::class, 'servicio_mantenimiento_id', 'id_mant');
    }
}
