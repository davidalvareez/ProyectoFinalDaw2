<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblComentarios extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_comentarios', function (Blueprint $table) {

            $table->id();
            $table->string('desc_comentario');
            $table->float('val_comentario');
            $table->unsignedBigInteger('id_contenido');
            $table->unsignedBigInteger('id_usu');

            $table->foreign('id_contenido')->references('id')->on('tbl_contenidos');
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
        Schema::dropIfExists('tbl_comentarios');
    }
}
