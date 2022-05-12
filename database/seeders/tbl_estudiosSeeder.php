<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_estudiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ID = 1
        DB::table('tbl_estudios')->insert([
            'id_usu' => '14',
            'id_curso' => '4'
        ]);

        //ID = 2
        DB::table('tbl_estudios')->insert([
            'id_usu' => '15',
            'id_curso' => '7'
        ]);

        //ID = 3
        DB::table('tbl_estudios')->insert([
            'id_usu' => '17',
            'id_curso' => '1'
        ]);

        //ID = 4
        DB::table('tbl_estudios')->insert([
            'id_usu' => '16',
            'id_curso' => '6'
        ]);

        //ID = 5
        DB::table('tbl_estudios')->insert([
            'id_usu' => '18',
            'id_curso' => '5'
        ]);
    }
}
