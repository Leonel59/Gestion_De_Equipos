<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado_equipo',
        'tipo_equipo',
        'cod_equipo',
        'marca_equipo',
        'modelo_equipo',
        'numero_serie',
        'precio_equipo',
        'fecha_adquisicion',
        'serie_cargador_comp',
        'procesador_comp',
        'memoria_comp',
        'tarjeta_grafica_comp',
        'tipodisco_comp',
        'sistema_operativo_comp',
        'tipo_impresora',
        'resolucion_impresora',
        'conectividad_impresora',
        'capacidad',
        'tamano',
        'color'
    ];

    protected $table = 'equipos'; // Nombre de la tabla
    protected $primaryKey = 'id_equipo'; // Clave primaria
    public $timestamps = true; // Esto es opcional, según tu configuración

    public function propiedades_computadoras()
    {
        return $this->hasMany(PropiedadesComputadoras::class, 'id_equipo', 'id_equipo');
    }

    public function propiedades_impresoras()
    {
        return $this->hasMany(PropiedadesImpresoras::class, 'id_equipo', 'id_equipo');
    }

    public function propiedades_otroequipo()
    {
        return $this->hasMany(PropiedadesOtroEquipo::class, 'id_equipo', 'id_equipo');
    }

   
}