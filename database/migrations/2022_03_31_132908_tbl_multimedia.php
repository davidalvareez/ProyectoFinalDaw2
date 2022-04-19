<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblMultimedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_multimedia', function (Blueprint $table) {

            $table->unsignedBigInteger('id');
            $table->string('duracion_contenido');

            $table->foreign('id')->references('id')->on('tbl_contenidos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_multimedia');
    }
}
