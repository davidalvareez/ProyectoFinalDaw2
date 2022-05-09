<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblCurriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_curriculum', function (Blueprint $table) {

            $table->id();
            $table->string('nombre_curriculum')->nullable();
            $table->unsignedBigInteger('id_usu');

            $table->foreign('id_usu')->references('id')->on('tbl_usuario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_curriculum');
    }
}
