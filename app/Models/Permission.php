<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission; // Importa el modelo base de Spatie
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends SpatiePermission
{
    use HasFactory;

    // Aquí puedes agregar propiedades o métodos personalizados si lo necesitas
}
