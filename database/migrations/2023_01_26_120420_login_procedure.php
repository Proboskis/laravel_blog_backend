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
                IN `email` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `pass` CHAR(64) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            READS SQL DATA
            MODIFIES SQL DATA
            BEGIN
                IF `username` = '' THEN SET `username` = NULL; END IF;
                IF `email` = '' THEN SET `email` = NULL; END IF;
                IF `pass` = '' THEN
                    SET @message_text = 'The password must be provided ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                END IF;
                IF `username` IS NOT NULL THEN
                    SELECT users.id, users.username, users.salt
                    INTO @id, @username, @salt FROM users WHERE users.username = username;
                    IF (SELECT COUNT(users.id) FROM users WHERE users.username = username
                    AND users.password = UNHEX(SHA1(CONCAT(HEX(@salt), pass)))) != TRUE THEN
                        SET @message_text = 'Incorrect credentials';
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                    ELSE
                        SET @b_token = f_generate_token(@username);
                        SELECT @id AS id, @username AS username, @b_token AS bearer_token;
                    END IF;
                ELSEIF `email` IS NOT NULL THEN
                    SELECT users.id, users.email, users.salt
                    INTO @id, @email, @salt FROM users WHERE users.email = email;
                    IF (SELECT COUNT(users.id) FROM users WHERE users.email = email
                    AND users.password = UNHEX(SHA1(CONCAT(HEX(@salt), pass)))) != TRUE THEN
                        SET @message_text = 'Incorrect credentials';
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                    ELSE
                        SET @b_token = f_generate_token(@username);
                        INSERT INTO `personal_access_tokens2` (name, token, abilities, last_used_at)
                        VALUES ('auth_token', @b_token, '*', CURRENT_TIMESTAMP);
                        SELECT @id AS id, @email AS email, @b_token AS bearer_token;
                    END IF;
                ELSE
                    SET @message_text = 'At least one of these two, email or password must be provided ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
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
