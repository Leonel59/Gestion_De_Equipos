<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod_equipo',
        'tipo_equipo',
        'numero_serie',
        'marca_equipo',
        'modelo_equipo',
        'precio_equipo',
        'fecha_adquisicion',
        'depreciacion_equipo',
        'estado_equipo', // Agregar el campo estado_equipo aquí
        'id_usuario',
    ];

    // Especifica la clave primaria
    protected $primaryKey = 'cod_equipo'; // Cambia 'cod_equipo' si tu clave primaria tiene otro nombre
    public $incrementing = false; // Cambia a true si 'cod_equipo' es autoincrementable, false si no lo es
    protected $keyType = 'string'; // Cambia a 'int' si tu clave primaria es un número

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario'); // Asegúrate de que 'id_usuario' sea el campo correcto en tu base de datos
    }

}
