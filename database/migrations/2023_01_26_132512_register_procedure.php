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
            CREATE PROCEDURE sp_register_new_user(
                IN username VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `mail` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN pass CHAR(64) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            BEGIN
                IF (SELECT COUNT(users.id) FROM users WHERE users.username = username) > 0 THEN
                    SET @message_text = CONCAT('User \'', username, '\' already exists');
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
                ELSE
                    SET @salt = UNHEX(SHA1(CONCAT(RAND(), RAND(), RAND())));
                    INSERT INTO users(username, email, salt, password)
                    VALUES (username, mail, @salt, UNHEX(SHA1(CONCAT(HEX(@salt), pass))));
                END IF;
            END
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
        $procedure = " DROP PROCEDURE IF EXISTS `sp_register_new_user`; ";

        DB::unprepared($procedure);
    }
};
