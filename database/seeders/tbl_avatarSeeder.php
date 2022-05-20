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
            'img_avatar' => 'uploads/avatar/avatar1.jpg',
        ]);

        //ID = 2
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/avatar2.jpg',
        ]);

        //ID = 3
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/avatar3.jpg',
        ]);

        //ID = 4
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/avatar4.jpg',
        ]);

        //ID = 5
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/avatar5.jpg',
        ]);

        //ID = 6
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Sistema',
            'img_avatar' => 'uploads/avatar/avatar6.jpg',
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
            'img_avatar' => 'uploads/avatar/aaaaaa.jfif',
            'id_usu' => '2'
        ]);
        //ID = 9
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/chumchumMike.jpg',
            'id_usu' => '3'
        ]);
        //ID = 10
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/spiderman.png',
            'id_usu' => '4'
        ]);
        //ID = 11
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/monoXavi.png',
            'id_usu' => '5'
        ]);
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/puyolumtiti.jpg',
            'id_usu' => '6'
        ]);
        //ID = 13
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/patricioCulo.jpg',
            'id_usu' => '7'
        ]);

        //ID = 14
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/messi.png',
            'id_usu' => '8'
        ]);

        //ID = 15
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/KimFunny.jfif',
            'id_usu' => '9'
        ]);

        //ID = 16
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/NarutoCulo.png',
            'id_usu' => '10'
        ]);

        //ID = 17
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/narutoFunny.jfif',
            'id_usu' => '11'
        ]);

        //ID = 18
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/patricio2.jpg',
            'id_usu' => '12'
        ]);

        //ID = 19
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/music.webp',
            'id_usu' => '13'
        ]);

        //ID = 20
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/willbarca.jpeg',
            'id_usu' => '14'
        ]);

        //ID = 21
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/SA.jpg',
            'id_usu' => '15'
        ]);

        //ID = 22
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/ivan.jpg',
            'id_usu' => '16'
        ]);

        //ID = 23
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/bobesponja.jfif',
            'id_usu' => '17'
        ]);

        //ID = 24
        DB::table('tbl_avatar')->insert([
            'tipo_avatar' => 'Usuario',
            'img_avatar' => 'uploads/avatar/cr7.jfif',
            'id_usu' => '18'
        ]);
    }
}
