<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblContenidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_contenidos', function (Blueprint $table) {

            $table->id();
            $table->string('nombre_contenido');
            //$table->string('ruta_contenido');
            $table->string('idioma_contenido');
            $table->string('extension_contenido');
            $table->dateTime('fecha_publicacion_contenido');
            $table->unsignedBigInteger('id_tema')->nullable();;
            $table->unsignedBigInteger('id_usu');

            $table->foreign('id_tema')->references('id')->on('tbl_temas');
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
        Schema::dropIfExists('tbl_contenidos');
    }
}
