<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $procedure = "
            CREATE PROCEDURE sp_log_in(
                IN `username` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `pass` CHAR(64) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            READS SQL DATA
            BEGIN
                SET `username` = IFNULL(`username`, NULL);
                IF `username` IS NOT NULL THEN
                    SELECT users.id, users.username, users.salt
                    INTO @id, @username, @salt FROM users WHERE users.username = username;
                    IF (SELECT COUNT(users.id) FROM users WHERE users.username = username
                    AND users.password = UNHEX(SHA1(CONCAT(HEX(@salt), pass)))) != TRUE THEN
                        SET @message_text = 'Incorrect credentials';
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                    ELSE
                        SELECT @id AS id, @username AS username;
                    END IF;
                ELSE
                    SET @message_text = 'Username can not be empty ...';
                    SELECT @message_text;
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
    public function down(): void
    {
        $procedure = " DROP PROCEDURE IF EXISTS `sp_log_in`; ";

        DB::unprepared($procedure);
    }
};
