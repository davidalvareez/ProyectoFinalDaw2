<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            tbl_centroSeeder::class,
            tbl_cursosSeeder::class,
            tbl_asignaturasSeeder::class,
            tbl_temasSeeder::class,
            tbl_rolSeeder::class,
            tbl_nivelesSeeder::class,
            tbl_usuariosSeeder::class,
            tbl_avatarSeeder::class,
            tbl_contenidosSeeder::class,
            tbl_estudiosSeeder::class,
        ]);
    }
}
