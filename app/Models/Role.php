<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Role extends Model
{
    use HasFactory, HasRoles;

    // Define la relación con el modelo User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
}