<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_nivelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ID = 1
        DB::table('tbl_niveles')->insert([
            'nombre_nivel' => 'Nivel 1',
            'desc_nivel' => '5000 descargar y una valoración de usuario de 3 estrellas'
        ]);

        //ID = 2
        DB::table('tbl_niveles')->insert([
            'nombre_nivel' => 'Nivel 2',
            'desc_nivel' => '10000 descargar y una valoración de usuario de 3.5 estrellas'
        ]);

        //ID = 3
        DB::table('tbl_niveles')->insert([
            'nombre_nivel' => 'Nivel 3',
            'desc_nivel' => '5000 descargar y una valoración de usuario de 3 estrellas'
        ]);

        //ID = 4
        DB::table('tbl_niveles')->insert([
            'nombre_nivel' => 'Nivel 4',
            'desc_nivel' => '20000 descargar y una valoración de usuario de 4 estrellas'
        ]);

        //ID = 5
        DB::table('tbl_niveles')->insert([
            'nombre_nivel' => 'Nivel 5',
            'desc_nivel' => 'más de 60000 descargar y una valoración de usuario de 5 estrellas'
        ]);
    }
}
