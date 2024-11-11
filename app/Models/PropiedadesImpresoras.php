<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropiedadesImpresoras extends Model
{
    use HasFactory;

    protected $table = 'propiedades_impresoras'; // Nombre de la tabla
    protected $primaryKey = 'id_equipo'; // Cambia esto si tu clave primaria es diferente
    protected $fillable = [
        'id_equipo',
        'tipo_impresora',
        'resolucion_impresora',
        'conectividad_impresora',
    ];


    public function equipo()
    {
        return $this->belongsTo(Equipos::class, 'id_equipo', 'id_equipo'); // Relación inversa
    }
}


