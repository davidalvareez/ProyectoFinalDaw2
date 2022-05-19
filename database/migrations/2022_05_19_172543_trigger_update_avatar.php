<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TriggerUpdateAvatar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER UpdateAvatar BEFORE UPDATE ON `tbl_avatar`
        FOR EACH ROW
        BEGIN
          SET @avatarName = NEW.img_avatar;
          SET @OLDIMAGE = OLD.img_avatar;
          UPDATE `users` SET `image` = @avatarName WHERE `image` = @OLDIMAGE;
        END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `UpdateAvatar`');
    }
}
