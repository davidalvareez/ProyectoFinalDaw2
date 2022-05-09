<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblEstudios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_estudios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usu');
            $table->unsignedBigInteger('id_curso');

            $table->foreign('id_usu')->references('id')->on('tbl_usuario');
            $table->foreign('id_curso')->references('id')->on('tbl_cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_estudios');
    }
}
