<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sucursales')->insert([
            ['nombre_sucursal' => 'Distrito Central'],
            ['nombre_sucursal' => 'Catacamas'],
            ['nombre_sucursal' => 'Comayagua'],
            ['nombre_sucursal' => 'Danli'],
            ['nombre_sucursal' => 'La Esperanza'],
            ['nombre_sucursal' => 'Juticalpa'],
            ['nombre_sucursal' => 'Gracias'],
            ['nombre_sucursal' => 'Choluteca'],
            ['nombre_sucursal' => 'Marcala'],
        ]);
    }
}
