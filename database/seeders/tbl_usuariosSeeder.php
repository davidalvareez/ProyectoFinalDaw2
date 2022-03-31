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
    }
}
