<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ID = 1
        DB::table('tbl_rol')->insert([
            'nombre_rol' => 'Administrador'
        ]);

        //ID = 2
        DB::table('tbl_rol')->insert([
            'nombre_rol' => 'Moderador'
        ]);

        //ID= 3
        DB::table('tbl_rol')->insert([
            'nombre_rol' => 'Cliente'
        ]);

        //ID= 4
        DB::table('tbl_rol')->insert([
            'nombre_rol' => 'Profesor'
        ]);

        //ID= 5
        DB::table('tbl_rol')->insert([
            'nombre_rol' => 'Empresa'
        ]);
    }
}
