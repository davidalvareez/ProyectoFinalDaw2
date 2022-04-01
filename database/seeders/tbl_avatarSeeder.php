<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_avatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //ID = 1
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/imagenDefault.png',
        ]);

        //ID = 2
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/imagenDefault.png',
        ]);

        //ID = 3
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/imagenDefault.png',
        ]);

        //ID = 4
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/imagenDefault.png',
        ]);

        //ID = 5
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/imagenDefault.png',
        ]);

        //ID = 6
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/imagenDefault.png',
        ]);

        //ID = 7
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/avatarraul.jpg',
            'id_usu' => '1'
        ]);

        //ID = 8
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/chumchumMike.jpg',
            'id_usu' => '3'
        ]);

        //ID = 8
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/aaaaaa.jfif',
            'id_usu' => '2'
        ]);

        //ID = 9
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/monoXavi.png',
            'id_usu' => '5'
        ]);

        //ID = 10
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/spiderman.png',
            'id_usu' => '4'
        ]);

    }
}
