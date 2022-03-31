<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblCentro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_centro', function (Blueprint $table) {

            $table->id();
            $table->string('nombre_centro');
            $table->string('pais_centro');
            $table->string('com_auto_centro');
            $table->string('ciudad_centro');
            $table->string('direccion_centro');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_centro');
    }
}
