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

    ];


    public function correos()
    {
        return $this->hasMany(Correos::class, 'id_proveedor', 'id_proveedor');
    }


    public function telefonos()
    {
        return $this->hasMany(Telefonos::class, 'id_proveedor', 'id_proveedor');
    }

    public function direcciones()
    {
        return $this->hasMany(Direcciones::class, 'id_proveedor', 'id_proveedor');
    }

}
