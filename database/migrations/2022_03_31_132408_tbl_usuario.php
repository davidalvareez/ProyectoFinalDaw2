<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nick_usu');
            $table->string('nombre_usu');
            $table->string('apellido_usu');
            $table->date('fecha_nac_usu');
            $table->string('correo_usu');
            $table->string('contra_usu');
            $table->date('deshabilitado')->nullable();
            $table->time('tmpdeshabilitado')->nullable();
            $table->boolean('validado');
            $table->unsignedBigInteger('id_centro')->nullable();
            $table->unsignedBigInteger('id_nivel')->nullable();
            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_centro')->references('id')->on('tbl_centro');
            $table->foreign('id_nivel')->references('id')->on('tbl_niveles');
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
        Schema::dropIfExists('tbl_usuario');
    }
}
