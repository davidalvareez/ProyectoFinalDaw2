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
        //Centro 5
        //ID 5
        DB::table('tbl_cursos')->insert([
            'nombre_curso' => 'Conservacion y Restauracion de Bienes Culturales',
            'nombre_corto_curso' => 'CRBBCC',
            'tipo_curso' => 'Universidad',
            'id_centro' => 5,
        ]);
        //Centro 2
        //ID 6
        DB::table('tbl_cursos')->insert([
            'nombre_curso' => 'Quimica',
            'nombre_corto_curso' => NULL,
            'tipo_curso' => 'Universidad',
            'id_centro' => 2,
        ]);
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        //ID 7
        DB::table('tbl_cursos')->insert([
            'nombre_curso' => 'Medicina UPF-UAB',
            'nombre_corto_curso' => NULL,
            'tipo_curso' => 'Universidad',
            'id_centro' => 6,
        ]);
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
