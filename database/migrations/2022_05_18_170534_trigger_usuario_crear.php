<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TriggerUsuarioCrear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER InsertAvatar AFTER INSERT ON `tbl_avatar`
        FOR EACH ROW
        BEGIN
          SET @avatarName = NEW.img_avatar;
          SET @nombre = (SELECT `nick_usu` FROM tbl_usuario WHERE id = NEW.id_usu);
          SET @email = (SELECT `correo_usu` FROM tbl_usuario WHERE id = NEW.id_usu);
          SET @emailVerified = NULL;
          SET @password = (SELECT `contra_usu` FROM tbl_usuario WHERE id = NEW.id_usu);
          SET @uuid = MD5(CONCAT(UUID(), NEW.id_usu));
          SET @token = NULL;
          SET @createdAT = NULL;
          SET @updatedAT =  NULL;
          IF NEW.id_usu IS NOT NULL THEN 
                    INSERT INTO users (`name`,`email`,`email_verified_at`,`password`,`uuid`,`image`,`remember_token`,`created_at`,`updated_at`)
                    VALUES (@nombre, @email, @emailVerified, @password, @uuid, @avatarName, @token, @createdAT, @updatedAT);
          END IF;
        END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `InsertAvatar`');
    }
}
