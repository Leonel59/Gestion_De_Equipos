<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suministros extends Model
{
    use HasFactory;

    // Definimos los campos que se pueden llenar mediante asignación masiva
    protected $fillable = [
        'id_proveedor',
        'nombre_suministro',
        'descripcion_suministro',
        'fecha_adquisicion',
        'cantidad_suministro',
        'costo_unitario'
    ];

    // Definimos el nombre de la tabla en la base de datos (opcional si el nombre sigue la convención)
    protected $table = 'suministros';

    // Definimos la clave primaria (opcional si se usa 'id' como nombre de clave primaria)
    protected $primaryKey = 'id_suministro';

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }


   
    public function asignaciones()
    {
        return $this->belongsToMany(Asignaciones::class, 'asignacion_suministros', 'id_suministro', 'id_asignacion');
    }
    


public function reducirCantidad($cantidad)
{
    if ($this->cantidad_suministro >= $cantidad) {
        $this->cantidad_suministro -= $cantidad;
        $this->costo_total = $this->cantidad_suministro * $this->costo_unitario;
        $this->save();
    } else {
        throw new \Exception('Cantidad insuficiente en el inventario.');
    }
}

public function aumentarCantidad($cantidad)
{
    $this->cantidad_suministro += $cantidad;
    $this->costo_total = $this->cantidad_suministro * $this->costo_unitario;
    $this->save();
}


    
}
