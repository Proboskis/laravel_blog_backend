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
            CREATE PROCEDURE sp_register_new_user(
                IN `username` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `mail` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `pass` CHAR(64) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `pass_confirm` CHAR(64) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            MODIFIES SQL DATA
            BEGIN
                IF `username` = '' THEN
                    SET @message_text = 'The username field can not be empty ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                END IF;
                IF `mail` = '' THEN
                    SET @message_text = 'The email field can not be empty ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                END IF;
                IF `pass` = '' THEN
                    SET @message_text = 'The password field can not be empty ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                END IF;
                    IF `pass_confirm` = '' THEN
                    SET @message_text = 'The password confirmation field can not be empty ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                END IF;
                IF (SELECT COUNT(users.id) FROM users WHERE users.username = username) > 0 THEN
                    SET @message_text = 'Try again with different credentials, username or email might be taken ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                ELSEIF (SELECT COUNT(users.id) FROM users WHERE users.email = mail) > 0 THEN
                    SET @message_text = 'Try again with different credentials, username or email might be taken ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1001;
                ELSE
                    IF `pass` != `pass_confirm` THEN
                        SET @message_text = 'The passwords do not match ...';
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                    ELSE
                        SET @salt = UNHEX(SHA1(CONCAT(RAND(), RAND(), RAND())));
                        INSERT INTO users(username, email, salt, password)
                        VALUES (username, mail, @salt, UNHEX(SHA1(CONCAT(HEX(@salt), pass))));
                        SET @message_text = CONCAT('User ', username, ' registered successfully');
                        SELECT @message_text AS response;
                    END IF;
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
        $procedure = " DROP PROCEDURE IF EXISTS `sp_register_new_user`; ";

        DB::unprepared($procedure);
    }
};
