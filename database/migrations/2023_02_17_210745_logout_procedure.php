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
    public function up() : void
    {
        $procedure = "
            CREATE PROCEDURE sp_log_out(
                IN `token` VARCHAR(90) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            MODIFIES SQL DATA
            BEGIN
                IF `token` = '' THEN SET `token` = NULL; END IF;
                IF `token` = NULL THEN
                    SET @message_text = 'The token must be provided ...';
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text, MYSQL_ERRNO = 1644;
                END IF;
                IF `token` IS NOT NULL THEN
                    DELETE FROM personal_access_tokens2 WHERE personal_access_tokens2.token = token;
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
    public function down() : void
    {
        $procedure = " DROP PROCEDURE IF EXISTS `sp_log_out`; ";

        DB::unprepared($procedure);
    }
};
