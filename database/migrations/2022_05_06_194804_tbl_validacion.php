<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblValidacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_validacion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code');
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
        Schema::dropIfExists('tbl_validacion');
    }
}
