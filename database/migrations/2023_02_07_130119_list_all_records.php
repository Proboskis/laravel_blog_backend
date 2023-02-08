<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
                IN `username` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `mail` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `pass` CHAR(64) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN `pass_confirm` CHAR(64) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
            )
            MODIFIES SQL DATA
            BEGIN

            END
        ";
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
