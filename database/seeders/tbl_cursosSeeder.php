<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_cursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*-------------------------- XAVI GOMEZ ----------------*/
        //Centro 1
        //ID 1
        DB::table('tbl_cursos')->insert([
            'nombre_curso' => 'Estetica integral y bienestar',
            'nombre_corto_curso' => NULL,
            'tipo_curso' => 'FP Superior',
            'id_centro' => 1,
        ]);
        //Centro 2
        //ID 2
        DB::table('tbl_cursos')->insert([
            'nombre_curso' => 'Filosofia',
            'nombre_corto_curso' => NULL,
            'tipo_curso' => 'Universidad',
            'id_centro' => 2,
        ]);
        //Centro 3
        //ID 3
        DB::table('tbl_cursos')->insert([
            'nombre_curso' => 'Marketing y publicidad',
            'nombre_corto_curso' => NULL,
            'tipo_curso' => 'FP Superior',
            'id_centro' => 3,
        ]);
        //Centro 4
        //ID 4
        DB::table('tbl_cursos')->insert([
            'nombre_curso' => 'Marketing y publicidad',
            'nombre_corto_curso' => NULL,
            'tipo_curso' => 'FP Superior',
            'id_centro' => 4,
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
