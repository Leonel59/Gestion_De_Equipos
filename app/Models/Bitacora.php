<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'id_usuario',
        'tabla',
        'accion',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario'); 
    }
}
