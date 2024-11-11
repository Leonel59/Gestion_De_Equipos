<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correos extends Model
{
    use HasFactory;

    protected $table = 'correos';
    protected $primaryKey = 'id_correos';
    public $timestamps = false;
   
    protected $fillable = [
        'cod_empleados',
        'correo_personal',
        'correo_profesional'
        
    ];


    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cod_empleados', 'cod_empleados');
    }
}
