<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor'; // Especificar la tabla
    protected $primaryKey = 'id_proveedor'; // Clave primaria
    protected $fillable = [
        'nombre_proveedor',
        'rtn_proveedor',
        'contacto_proveedor',
        'direccion_proveedor',
        'telefono_proveedor',
        'email_proveedor',
    ];
}
