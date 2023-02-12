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
    public function up()
    {
        $procedure = "
            CREATE FUNCTION f_generate_token(
                `username` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            RETURNS VARCHAR(90)
            NOT DETERMINISTIC
            BEGIN
                IF `username` = NULL THEN
                    SET @error_text = 'The username field can not be empty ...';
                    RETURN(@error_text);
                ELSE
                    SET @uuid_token = UUID();
                    SET @bearer_token = CONCAT(SHA1(username), @uuid_token);
                    RETURN(@bearer_token);
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
        //
    }
};
