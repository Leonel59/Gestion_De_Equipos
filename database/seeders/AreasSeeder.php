<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = ['Administracion', 'Contabilidad', 'Recursos Humanos', 'Ventas', 'Gerencia IT'];

        for ($sucursal_id = 1; $sucursal_id <= 9; $sucursal_id++) {
            foreach ($areas as $area) {
                DB::table('areas')->insert([
                    'id_sucursal' => $sucursal_id,
                    'nombre_area' => $area,
                ]);
            }
        }
    }
}