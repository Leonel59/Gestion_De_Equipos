<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropiedadesComputadoras extends Model
{
    use HasFactory;

    protected $table = 'propiedades_computadoras'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'id_equipo',
        'procesador_comp',
        'memoria_comp',
        'tipodisco_comp',
        'sistema_operativo_comp',
    ];

    // Relación inversa con el modelo Equipos
    public function equipo()
    {
        return $this->belongsTo(Equipos::class, 'id_equipo', 'id_equipo');
    }
}


