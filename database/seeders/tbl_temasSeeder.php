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
            'nombre_tema' => 'Ultrasonidos y Mecanoterapia',
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
            'nombre_tema' => 'Distribucion',
            'id_asignatura' => 10
        ]);
        //Asignatura 11
        //ID 14
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Tema 4',
            'id_asignatura' => 11
        ]);
        //Asignatura 12
        //ID 15
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Fuentes de informacion interna y externa',
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
            'nombre_tema' => 'Fuentes de informacion y normativa',
            'id_asignatura' => 15
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        //Asignatura 16
        //ID 19
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Primero',
            'id_asignatura' => 16
        ]);
        //Asignatura 17
        //ID 20
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Primero',
            'id_asignatura' => 17
        ]);
        //ID 21
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Segundo',
            'id_asignatura' => 17
        ]);
        //Asignatura 18
        //ID 22
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Segundo',
            'id_asignatura' => 18
        ]);
        //Asignatura 19
        //ID 23
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Segundo',
            'id_asignatura' => 19
        ]);
        //Asignatura 20
        //ID 24
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Segundo',
            'id_asignatura' => 20
        ]);
        //Asignatura 21
        //ID 25
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Primero',
            'id_asignatura' => 21
        ]);
        //Asignatura 22
        //ID 26
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Segundo',
            'id_asignatura' => 22
        ]);
        //Asignatura 23
        //ID 27
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Tercero',
            'id_asignatura' => 23
        ]);
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        //Asignatura 24
        //ID 28
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Farmacología',
            'id_asignatura' => 24
        ]);
        //Asignatura 25
        //ID 29
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Inmunología',
            'id_asignatura' => 25
        ]);
        //Asignatura 26
        //ID 30
        DB::table('tbl_temas')->insert([
            'nombre_tema' => 'Microbiología',
            'id_asignatura' => 26
        ]);
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
