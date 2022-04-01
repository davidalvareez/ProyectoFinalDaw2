<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class tbl_temasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*-------------------------- XAVI GOMEZ ----------------*/
        //Asignatura 1
        //ID 1
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Marketing en Imagen Personal',
            'id_asignatura' => 1
        ]);
        //Asignatura 2
        //ID 2
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Tema 6 y 7: Ultrasonidos y Mecanoterapia',
            'id_asignatura' => 2
        ]);
        //Asignatura 3
        //ID 3
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Tema 1',
            'id_asignatura' => 3
        ]);
        //Asignatura 4
        //ID 4
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Problemas de ontologia',
            'id_asignatura' => 4
        ]);
        //ID 5
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Identidad personal',
            'id_asignatura' => 4
        ]);
        //ID 6
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Conocimiento humano y sus limites',
            'id_asignatura' => 4
        ]);
        //Asignatura 5
        //ID 7
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Apuntes examen',
            'id_asignatura' => 5
        ]);
        //Asignatura 6
        //ID 8
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Comentario kant',
            'id_asignatura' => 6
        ]);
        //Asignatura 7
        //ID 9
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Plan de formacion',
            'id_asignatura' => 7
        ]);
        //ID 10
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Entrevistas',
            'id_asignatura' => 7
        ]);
        //Asignatura 8
        //ID 11
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Auditoria y asesoramiento',
            'id_asignatura' => 8
        ]);
        //Asignatura 9
        //ID 12
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'connectors',
            'id_asignatura' => 9
        ]);
        //Asignatura 10
        //ID 13
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Distribuccion',
            'id_asignatura' => 10
        ]);
        //Asignatura 11
        //ID 14
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Tema 4: Continuacion',
            'id_asignatura' => 11
        ]);
        //Asignatura 12
        //ID 15
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Tema 1: Fuentes de informacion interna y externa',
            'id_asignatura' => 12
        ]);
        //Asignatura 13
        //ID 16
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'UF3',
            'id_asignatura' => 13
        ]);
        //Asignatura 14 
        //ID 17
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Conceptos',
            'id_asignatura' => 14
        ]);
        //Asignatura 15
        //ID 18
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Tema 1: Fuentes de informacion y normativa',
            'id_asignatura' => 15
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
