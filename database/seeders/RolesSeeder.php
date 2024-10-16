<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'ADMINISTRADOR3']);
        $permission = Permission::create(['name' => 'VER_BITACORA3']);

        $permission->syncRoles($role);

        $usuario = User::find(1);

        $usuario->assignRole($role);
    }
}
