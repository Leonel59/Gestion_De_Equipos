<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropiedadesOtroEquipo extends Model
{
    use HasFactory;

    protected $table = 'propiedades_otroequipo'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'id_equipo',
        'capacidad',
        'tamano',
        'color',
    ];
 
    // Relación inversa con el modelo Equipos
    public function equipo()
    {
        return $this->belongsTo(Equipos::class, 'id_equipo');
    }
}
