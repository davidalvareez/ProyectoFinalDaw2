<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_usuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ID = 1
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'xWhiite',
            'nombre_usu' => 'Raúl',
            'apellido_usu' => 'Santacruz Cela',
            'fecha_nac_usu' => '2001-12-16',
            'correo_usu' => 'raul@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => '1'
        ]);

        //ID = 2
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Marc_Ortiz02',
            'nombre_usu' => 'Marc',
            'apellido_usu' => 'Ortiz González',
            'fecha_nac_usu' => '2002-12-17',
            'correo_usu' => 'marc@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => '1'
        ]);

        //ID = 3
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Mike',
            'nombre_usu' => 'Miguel',
            'apellido_usu' => 'Gras Garrido',
            'fecha_nac_usu' => '2001-11-05',
            'correo_usu' => 'miguel@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => '1'
        ]);

        //ID = 4
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Davidalvareez',
            'nombre_usu' => 'David',
            'apellido_usu' => 'Alvarez Rodriguez',
            'fecha_nac_usu' => '2001-04-08',
            'correo_usu' => 'david@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => '1'
        ]);

        //ID = 5
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'xaviermireia1',
            'nombre_usu' => 'Xavi',
            'apellido_usu' => 'Gómez Gallego',
            'fecha_nac_usu' => '2001-09-29',
            'correo_usu' => 'xavi@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => '1'
        ]);
        //ID = 6
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Skrisirex',
            'nombre_usu' => 'Isaac',
            'apellido_usu' => 'Ortiz Moncusí',
            'fecha_nac_usu' => '2001-05-11',
            'correo_usu' => 'isaac@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => '1'
        ]);
        /*-------------------------- XAVI GOMEZ ----------------*/
        //ID = 7
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'andrea.gb24',
            'nombre_usu' => 'Andreea',
            'apellido_usu' => 'Cerchia',
            'fecha_nac_usu' => '2001-04-24',
            'correo_usu' => 'andreagb24@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_centro' => 1,
            'id_rol' => '3',
        ]);
        //ID = 8
        DB::table('tbl_usuario')->insert([
            'nick_usu' => '18anais',
            'nombre_usu' => 'Anais',
            'apellido_usu' => 'Redondo Dominguez',
            'fecha_nac_usu' => '2001-05-18',
            'correo_usu' => 'anaisredondo@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_centro' => 3,
            'id_rol' => '3'
        ]);
        //ID = 9
        DB::table('tbl_usuario')->insert([
            'nick_usu' => '_jordisn',
            'nombre_usu' => 'Jordi',
            'apellido_usu' => 'San Nicolas',
            'fecha_nac_usu' => '2001-11-25',
            'correo_usu' => 'jordiSanNicolas@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_centro' => 2,
            'id_rol' => '3'
        ]);
        //ID = 10
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'alba.subirats',
            'nombre_usu' => 'Alba',
            'apellido_usu' => 'Subirats',
            'fecha_nac_usu' => '2002-11-29',
            'correo_usu' => 'albasubirats@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_centro' => 4,
            'id_rol' => '3'
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
