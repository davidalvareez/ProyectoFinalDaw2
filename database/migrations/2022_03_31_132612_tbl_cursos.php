<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblCursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cursos', function (Blueprint $table) {

            $table->id();
            $table->string('nombre_curso');
            $table->string('nombre_corto_curso')->nullable();
            $table->string('tipo_curso');
            $table->unsignedBigInteger('id_centro');

            $table->foreign('id_centro')->references('id')->on('tbl_centro');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_cursos');
    }
}
