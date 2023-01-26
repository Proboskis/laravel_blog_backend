<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            DELIMITER $$

            DROP PROCEDURE IF EXISTS `sp_register_new_user`$$
            CREATE PROCEDURE `sp_register_new_user` (
                IN `mail` VARCHAR(48),
                IN `pass` VARCHAR(48)
            )
            MODIFIES SQL DATA
            BEGIN
                DECLARE `_salt` CHAR(24);
                SET `_salt` = SUBSTRING(MD5(RAND()), -24);
                INSERT INTO `users`(`email`, `password`, `salt`)
                VALUES (`mail`, UNHEX(SHA1(CONCAT(`pass`, `_salt`))), UNHEX(`_salt`));
            END$$

            DELIMITER ;
        ";

        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $procedure = " DROP PROCEDURE IF EXISTS `sp_register_new_user` ";

        DB::unprepared($procedure);
    }
};
