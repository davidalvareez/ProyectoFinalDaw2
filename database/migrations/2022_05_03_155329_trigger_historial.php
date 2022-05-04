<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TriggerHistorial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER ControlHistorial BEFORE INSERT ON `tbl_historial`
        FOR EACH ROW
        BEGIN
          SET @countInsUsu = (SELECT COUNT(*) FROM tbl_historial WHERE id_usu = NEW.id_usu AND id_contenido = NEW.id_contenido);
          IF @countInsUsu >= 1
            THEN SIGNAL SQLSTATE '45000'
              SET MESSAGE_TEXT = 'Este usuario ya ha descargado este apunte';
          END IF;
        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `ControlHistorial`');
    }
}
