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
            CREATE PROCEDURE sp_token_comparator(
                IN `token` VARCHAR(90) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            READS SQL DATA
            BEGIN
            IF (SELECT COUNT(personal_access_tokens2.id)
                FROM personal_access_tokens2 WHERE personal_access_tokens2.token = token) > 0 THEN
                SELECT token FROM personal_access_tokens2 WHERE personal_access_tokens2.token = token;
            ELSE
                SET @invalid_value = 0;
                SELECT @invalid_value;
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
        $procedure = " DROP PROCEDURE IF EXISTS `sp_token_comparator`; ";

        DB::unprepared($procedure);
    }
};
