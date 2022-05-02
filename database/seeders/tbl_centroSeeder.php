<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_centroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*-------------------------- XAVI GOMEZ ----------------*/
        //ID 1
        DB::table('tbl_centro')->insert([
            'nombre_centro' => 'IES BARRIO DE BILBAO',
            'pais_centro' => 'España',
            'com_auto_centro' => 'Madrid',
            'ciudad_centro' => 'Madrid',
            'direccion_centro' => 'C. de Villaescusa, 19, 28017 Madrid'
        ]);
        //ID 2
        DB::table('tbl_centro')->insert([
            'nombre_centro' => 'Universitat de Barcelona',
            'pais_centro' => 'España',
            'com_auto_centro' => 'Cataluña',
            'ciudad_centro' => 'Barcelona',
            'direccion_centro' => 'Gran Via de les Corts Catalanes, 585, 08007 Barcelona'
        ]);
        //ID 3
        DB::table('tbl_centro')->insert([
            'nombre_centro' => 'IFP innovacion en formacion profesional',
            'pais_centro' => 'España',
            'com_auto_centro' => 'Cataluña',
            'ciudad_centro' => 'Barcelona',
            'direccion_centro' => 'Av. de Josep Tarradellas i Joan, 171, 177, 08901 Hospitalet de Llobregat, Barcelona'
        ]);
        //ID 4
        DB::table('tbl_centro')->insert([
            'nombre_centro' => 'Escola universitaria Euroaula',
            'pais_centro' => 'España',
            'com_auto_centro' => 'Cataluña',
            'ciudad_centro' => 'Barcelona',
            'direccion_centro' => 'C/ Aragó, 208, 210, 08011 Barcelona'
        ]);
        /*-------------------------- MIGUEL GRAS ----------------*/
        //ID 5
        DB::table('tbl_centro')->insert([
            'nombre_centro' => 'Universitat Politecnica de Valencia',
            'pais_centro' => 'España',
            'com_auto_centro' => 'Valencia',
            'ciudad_centro' => 'Valencia',
            'direccion_centro' => 'Camí de Vera, s/n, 46022 València, Valencia'
        ]);
        /*-------------------------- RAUL SANTACRUZ ----------------*/
        //ID 6
        DB::table('tbl_centro')->insert([
            'nombre_centro' => 'Universitat Pompeu Fabra',
            'pais_centro' => 'España',
            'com_auto_centro' => 'Barcelona',
            'ciudad_centro' => 'Barcelona',
            'direccion_centro' => 'Plaça de la Mercè, 10-12, 08002 Barcelona'
        ]);
        /*-------------------------- DAVID ALVAREZ ----------------*/
        /*-------------------------- MARC ORTIZ ----------------*/
        /*-------------------------- ISAAC ORTIZ ----------------*/
    }
}
