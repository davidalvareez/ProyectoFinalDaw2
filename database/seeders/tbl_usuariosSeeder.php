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
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '1'
        ]);

        //ID = 2
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Marc_Ortiz02',
            'nombre_usu' => 'Marc',
            'apellido_usu' => 'Ortiz González',
            'fecha_nac_usu' => '2002-12-17',
            'correo_usu' => 'marc@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '1'
        ]);

        //ID = 3
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Mike',
            'nombre_usu' => 'Miguel',
            'apellido_usu' => 'Gras Garrido',
            'fecha_nac_usu' => '2001-11-05',
            'correo_usu' => 'miguel@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '1'
        ]);

        //ID = 4
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Davidalvareez',
            'nombre_usu' => 'David',
            'apellido_usu' => 'Alvarez Rodriguez',
            'fecha_nac_usu' => '2001-04-08',
            'correo_usu' => 'david@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '1'
        ]);

        //ID = 5
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'xaviermireia1',
            'nombre_usu' => 'Xavi',
            'apellido_usu' => 'Gómez Gallego',
            'fecha_nac_usu' => '2001-09-29',
            'correo_usu' => 'xavi@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '1'
        ]);
        //ID = 6
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'Skrisirex',
            'nombre_usu' => 'Isaac',
            'apellido_usu' => 'Ortiz Moncusí',
            'fecha_nac_usu' => '2001-05-11',
            'correo_usu' => 'isaac@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '2'
        ]);
        /*-------------------------- XAVI GOMEZ ----------------*/
        //ID = 7
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'andrea.gb24',
            'nombre_usu' => 'Andreea',
            'apellido_usu' => 'Cerchia',
            'fecha_nac_usu' => '2001-04-24',
            'correo_usu' => 'andreagb199@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
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
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
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
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
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
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_centro' => 4,
            'id_rol' => '3'
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        //ID = 11
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'lydia.sanchez',
            'nombre_usu' => 'Lydia',
            'apellido_usu' => 'Sanchez',
            'fecha_nac_usu' => '2001-08-16',
            'correo_usu' => 'lydiasanchez@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_centro' => 5,
            'id_rol' => '3'
        ]);
        //ID = 12
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'lorena.dona',
            'nombre_usu' => 'Lorena',
            'apellido_usu' => 'Dona',
            'fecha_nac_usu' => '2001-12-23',
            'correo_usu' => 'lorenadona@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_centro' => 2,
            'id_rol' => '3'
        ]);
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        //ID = 13
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'albaespan',
            'nombre_usu' => 'Alba',
            'apellido_usu' => 'España',
            'fecha_nac_usu' => '2001-09-16',
            'correo_usu' => 'albaespana@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_centro' => 6,
            'id_rol' => '3'
        ]);
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
        /*-------------------------- EJEMPLO PROFESORES PRUEBA ----------------*/
        //ID = 14
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'TomásDeMichele',
            'nombre_usu' => 'Tomás',
            'apellido_usu' => 'De Michele',
            'fecha_nac_usu' => '1985-09-16',
            'correo_usu' => 'tomasmichele@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '4'
        ]);

        //ID = 15
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'DoloresCrotal',
            'nombre_usu' => 'Dolores',
            'apellido_usu' => 'Crotal',
            'fecha_nac_usu' => '1985-10-16',
            'correo_usu' => 'dolorescrotal@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '4'
        ]);

        //ID = 16
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'KerryCabuela',
            'nombre_usu' => 'Kerry',
            'apellido_usu' => 'Cabuela',
            'fecha_nac_usu' => '1985-11-16',
            'correo_usu' => 'kerrycabuela@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '4'
        ]);

        //ID = 16
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'IsmaRicon',
            'nombre_usu' => 'Isma',
            'apellido_usu' => 'Ricon',
            'fecha_nac_usu' => '1985-12-16',
            'correo_usu' => 'ismaricon@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '4'
        ]);

        //ID = 17
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'FelipeNeduro',
            'nombre_usu' => 'Felipe',
            'apellido_usu' => 'Neduro',
            'fecha_nac_usu' => '1985-08-16',
            'correo_usu' => 'felipeneduro@gmail.com',
            'contra_usu' => hash('sha256','1234'),
            'validado' => true,
            'id_rol' => '4'
        ]);
    }
}
