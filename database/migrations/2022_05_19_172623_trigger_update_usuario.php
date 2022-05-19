<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TriggerUpdateUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER UpdateUsuario BEFORE UPDATE ON `tbl_usuario`
        FOR EACH ROW
        BEGIN
          SET @nombre = NEW.nick_usu;
          SET @correo = NEW.correo_usu;
          SET @password = NEW.contra_usu;
          SET @oldCorreo = OLD.correo_usu;
          UPDATE `users` SET `name` = @nombre, `email` = @correo, `password` = @password WHERE `email` = @oldCorreo;
        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `UpdateUsuario`');
    }
}
