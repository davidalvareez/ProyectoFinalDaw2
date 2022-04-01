<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class tbl_asignaturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*-------------------------- XAVI GOMEZ ----------------*/
        //Curso 1
        // ID 1
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Marketing en estetica y belleza',
            'id_curso' => 1
        ]);
        //ID 2
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Aparatologia',
            'id_curso' => 1
        ]);
        //Curso 2
        //ID 3
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Problemas filosoficos I',
            'id_curso' => 2
        ]);
        //ID 4
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Problemas filosoficos II',
            'id_curso' => 2
        ]);
        //ID 5
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Problemas filosoficos III',
            'id_curso' => 2
        ]);
        //ID 6
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Introduccion etica',
            'id_curso' => 2
        ]);
        //Curso 3
        //ID 7
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Trabajo de campo',
            'id_curso' => 3
        ]);
        //ID 8
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Marketing digital',
            'id_curso' => 3
        ]);
        //ID 9
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Ingles',
            'id_curso' => 3
        ]);
        //Curso 4
        //ID 10
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Politicas de marketing',
            'id_curso' => 4
        ]);
        //ID 11
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Organizacion de eventos',
            'id_curso' => 4
        ]);
        //ID 12
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Lanzamiento de productos y servicios',
            'id_curso' => 4
        ]);
        //ID 13
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Investigacion comercial',
            'id_curso' => 4
        ]);
        //ID 14
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'FOL',
            'id_curso' => 4
        ]);
        //ID 15
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Diseño y elaboracion de plan de comunicacion',
            'id_curso' => 4
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
