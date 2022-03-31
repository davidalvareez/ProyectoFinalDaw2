<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblPremium extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_premium', function (Blueprint $table) {

            $table->id();
            $table->dateTime('data_ini');
            $table->dateTime('data_fi');
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
        Schema::dropIfExists('tbl_premium');
    }
}
