<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TriggerDeleteUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER DeleteUsuario AFTER DELETE ON `tbl_usuario`
        FOR EACH ROW
        BEGIN
          SET @oldCorreo = OLD.correo_usu;
          DELETE FROM `users` WHERE `email` = @oldCorreo;
        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `DeleteUsuario`');
    }
}
