<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropiedadesImpresoras extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_equipo',
        'tipo_impresora',
        'resolucion_impresora',
        'conectividad_impresora',
    ];
}

