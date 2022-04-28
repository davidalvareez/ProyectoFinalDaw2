<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblEmpresa extends Migration
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
            $table->string('nombre_emp');
            $table->string('pais_emp');
            $table->string('localización_emp');
            $table->string('cp_emp');
            $table->string('correo_emp');
            $table->string('contra_emp');
            $table->string('web_emp');
            $table->string('logo_emp');

            $table->unsignedBigInteger('id_rol');

            $table->foreign('id_rol')->references('id')->on('tbl_rol');

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
