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

            DROP PROCEDURE IF EXISTS `sp_log_in` $$
            CREATE PROCEDURE `sp_log_in` (
               IN `mail` VARCHAR(50),
               IN `pass` VARCHAR(40),
               OUT `response_message` VARCHAR(64),
               OUT `ID` BIGINT
            )
            READS SQL DATA
            BEGIN
                DECLARE `_salt` CHAR(24);
                SET `ID` = NULL;

                SELECT LOWER(HEX(`salt`)) INTO `_salt` FROM `users` WHERE `email` = `mail`;
                IF (`_salt` IS NOT NULL)
                THEN
                    SELECT `id` INTO `ID` FROM `users` WHERE `email` = `mail`
                    AND `password` = UNHEX(SHA1(CONCAT(`pass`, `_salt`)));
                    IF(`ID` IS NULL) THEN
                        SET `response_message` = 'Incorrect password';
                    ELSE
                        SET `response_message` = 'Success';
                    END IF;
                ELSE
                    SET `response_message`='Error';
                END IF;
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
        $procedure = " DROP PROCEDURE IF EXISTS `sp_log_in` ";

        DB::unprepared($procedure);
    }
};