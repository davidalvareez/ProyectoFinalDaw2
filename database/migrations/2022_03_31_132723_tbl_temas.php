<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTemas extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_temas', function (Blueprint $table) {

            $table->id();
            $table->string('nombre_tema');
            $table->unsignedBigInteger('id_asignatura');

            $table->foreign('id_asignatura')->references('id')->on('tbl_asignaturas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_temas');
    }
}
