<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;

    protected $table = 'areas'; // nombre de la tabla en la base de datos
    protected $primaryKey = 'id_area'; // Define la clave primaria si es distinta de "id"

    protected $fillable = [
        'id_sucursal',
        'nombre_area'
    ];

    // Relación con el modelo Sucursal
    public function sucursales()
    {
        return $this->belongsTo(Sucursales::class, 'id_sucursal');
    }
}