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
        //ID 16
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Fundamento de la pintura',
            'id_curso' => 5
        ]);
        //ID 17
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Historia del Arte',
            'id_curso' => 5
        ]);
        //ID 18
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Tecnicas, procedimientos y materiales del dibujo',
            'id_curso' => 5
        ]);
        //ID 19
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Tecnicas, procedimientos y materiales escultoricos',
            'id_curso' => 5
        ]);
        //ID 20
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Tecnicas, procedimientos y materiales pictoricos',
            'id_curso' => 5
        ]);
        //ID 21
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Tecnologias de la imagen',
            'id_curso' => 5
        ]);
        //ID 22
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Quimica fisica',
            'id_curso' => 6
        ]);
        //ID 23
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Quimica organica',
            'id_curso' => 6
        ]);
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        //ID 24
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Farmacología',
            'id_curso' => 7
        ]);

        //ID 25
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Inmunología',
            'id_curso' => 7
        ]);

        //ID 26
        DB::table('tbl_asignaturas')->insert([
            'nombre_asignatura' => 'Microbiología',
            'id_curso' => 7
        ]);
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
