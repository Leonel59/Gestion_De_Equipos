<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropiedadesComputadoras extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_equipo',
        'procesador_comp',
        'memoria_comp',
        'tipodisco_comp',
        'sistema_operativo_comp',
    ];
}

