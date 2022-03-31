<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblAsignaturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_asignaturas', function (Blueprint $table) {

            $table->id();
            $table->string('nombre_asignatura');
            $table->unsignedBigInteger('id_curso');

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
        Schema::dropIfExists('tbl_asignaturas');
    }
}
