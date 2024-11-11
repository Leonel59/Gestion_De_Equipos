<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServiciosMantenimientos extends Model
{
    use HasFactory;


    // Definir el nombre de la clave primaria
    protected $primaryKey = 'id_mant';

    // Indica si la clave primaria es un número entero
    public $incrementing = false; // Si 'id_mant' no es auto-incremental, esto debe ser true

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_equipo_mant',
        'tipo_mantenimiento',
        'descripcion_mantenimiento',
        'cantidad_equipo_usado',
        'fecha_reparacion_equipo',
        'fecha_entrega_equipo',
        'costo_mantenimiento',
        'duracion_mantenimiento',
        'fecha_creacion',
        'modificado_por',
        'fecha_modificacion',
    ];

    
    public function equipo()
    {
        return $this->belongsTo(Equipos::class, 'id_equipo_mant', 'cod_equipo');
    }
    
}