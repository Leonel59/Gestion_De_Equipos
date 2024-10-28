<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'factura';

    // Llave primaria personalizada
    protected $primaryKey = 'cod_factura';

    // Atributos que pueden ser asignados masivamente
    protected $fillable = [
        'id_proveedor',
        'tipo_factura',
        'nombre_cliente',
        'rtn_cliente',
        'fecha_facturacion',
        'direccion_empresa',
        'cantidad',
        'descripcion',
        'garantia',
        'precio_unitario',
        'impuesto',
        'total'
    ];

    // Relación con el modelo Proveedor (una factura pertenece a un proveedor)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
}
