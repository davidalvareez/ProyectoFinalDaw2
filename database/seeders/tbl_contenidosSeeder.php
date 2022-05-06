<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class tbl_contenidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*-------------------------- XAVI GOMEZ ----------------*/
        //Tema 1
        //ID 1
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Resumen Marketing',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 1,
            'id_usu' => 7
        ]);
        //Tema 2
        //ID 2
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Apuntes Examen Aparatologia',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 2,
            'id_usu' => 7
        ]);
        //ID 3
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Aparatologia Tema 6 y 7',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 2,
            'id_usu' => 7
        ]);
        //Tema 3
        //ID 4
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'PF1_Ex2_SanNicolasJordi',
            'idioma_contenido' => 'Catalan',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 3,
            'id_usu' => 9
        ]);
        //Tema 4
        //ID 5
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Apunts parcial 2 PF2 TEMA 4',
            'idioma_contenido' => 'Catalan',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 4,
            'id_usu' => 9
        ]);
        //Tema 5
        //ID 6
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Apunts PF2 identitat personal',
            'idioma_contenido' => 'Catalan',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 5,
            'id_usu' => 9
        ]);
        //Tema 6
        //ID 7
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Apunts parcial 2 PF2 TEMA 5',
            'idioma_contenido' => 'Catalan',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 6,
            'id_usu' => 9
        ]);
        //Tema 7
        //ID 8
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Apunts examen PF3',
            'idioma_contenido' => 'Catalan',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 7,
            'id_usu' => 9
        ]);
        //Tema 8
        //ID 9
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Comentari kant',
            'idioma_contenido' => 'Catalan',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 8,
            'id_usu' => 9
        ]);
        //Tema 9
        //ID 10
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'plan de formacion',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 9,
            'id_usu' => 8
        ]);
        //Tema 10
        //ID 11
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Entrevistas y conclusiones',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 10,
            'id_usu' => 8
        ]);
        //Tema 11
        //ID 12
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tezenis auditoria y asesoramiento SEO',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 11,
            'id_usu' => 8
        ]);
        //Tema 12
        //ID 13
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Connectors Exercises Anais',
            'idioma_contenido' => 'Ingles',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 12,
            'id_usu' => 8
        ]);
        //Tema 13
        //ID 14
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Politicas de Marketing',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 13,
            'id_usu' => 10
        ]);
        //Tema 14
        //ID 15
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'JANET',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 14,
            'id_usu' => 10
        ]);
        //Tema 15
        //ID 16
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'DAVID',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 15,
            'id_usu' => 10
        ]);
        //Tema 16
        //ID 17
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Investigacion comercial',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 16,
            'id_usu' => 10
        ]);
        //Tema 17
        //ID 18
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'FOL UF2',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 17,
            'id_usu' => 10
        ]);
        //Tema 18
        //ID 19
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'YESSI',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 18,
            'id_usu' => 10
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        //Tema 19
        //ID 20
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 1',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 21
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 2',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 22
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 3',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 23
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 4',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 24
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 5',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 25
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 6',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 26
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 7',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 27
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 8',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 28
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 9',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 29
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 10',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 30
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 11',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 31
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Fundamentos de la pintura 12',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 19,
            'id_usu' => 11
        ]);
        //ID 32
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Historia del arte 1',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 20,
            'id_usu' => 11
        ]);
        //ID 33
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Historia del arte 2',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 21,
            'id_usu' => 11
        ]);
        //ID 34
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'ProcedDibuj',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 22,
            'id_usu' => 11
        ]);
        //ID 35
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnicas, procedimientos y materiales escultoricos 1',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 23,
            'id_usu' => 11
        ]);
        //ID 36
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnicas, procedimientos y materiales pictoricos 1',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 24,
            'id_usu' => 11
        ]);
        //ID 37
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnologias de la imagen 1',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 25,
            'id_usu' => 11
        ]);
        //ID 38
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnologias de la imagen 2',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 25,
            'id_usu' => 11
        ]);
        //ID 39
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnologias de la imagen 3',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 25,
            'id_usu' => 11
        ]);
        //ID 40
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnologias de la imagen 4',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 25,
            'id_usu' => 11
        ]);
        //ID 41
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnologias de la imagen 5',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 25,
            'id_usu' => 11
        ]);
        //ID 42
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Tecnologias de la imagen 6',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.jpeg',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 25,
            'id_usu' => 11
        ]);
        //ID 43
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Quimica fisica 1',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 26,
            'id_usu' => 12
        ]);
        //ID 44
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Quimica organica 1',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 27,
            'id_usu' => 12
        ]);
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        //ID 45
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Farmacología',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 28,
            'id_usu' => 13
        ]);

        //ID 46
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Inmunología',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 29,
            'id_usu' => 13
        ]);

        //ID 48
        DB::table('tbl_contenidos')->insert([
            'nombre_contenido' => 'Microbiología',
            'idioma_contenido' => 'Español',
            'extension_contenido' => '.pdf',
            'fecha_publicacion_contenido' => date('Y-m-d H:i:s'),
            'id_tema' => 30,
            'id_usu' => 13
        ]);
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
