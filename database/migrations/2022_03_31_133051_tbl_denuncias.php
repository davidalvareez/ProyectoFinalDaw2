<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblDenuncias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_denuncias', function (Blueprint $table) {

            $table->id();
            $table->string('tipus_denuncia');
            $table->string('desc_denuncia');
            $table->unsignedBigInteger('id_contenido')->nullable();
            $table->unsignedBigInteger('id_comentario')->nullable();
            $table->unsignedBigInteger('id_demandante');
            $table->unsignedBigInteger('id_acusado');

            $table->foreign('id_contenido')->references('id')->on('tbl_contenidos');
            $table->foreign('id_comentario')->references('id')->on('tbl_comentarios');
            $table->foreign('id_demandante')->references('id')->on('tbl_usuario');
            $table->foreign('id_acusado')->references('id')->on('tbl_usuario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_denuncias');
    }
}
