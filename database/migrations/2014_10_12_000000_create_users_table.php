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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('mobile_phone', 15)->unique()->nullable();
            $table->string('email', 50)->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->char('password', 20)->charset('binary');
//            $table->string('password', 40);
            $table->char('salt', 12)->charset('binary');
            $table->tinyText('intro')->nullable();
            $table->text('profile')->nullable();
            $table->rememberToken();
//            $table->timestamps();
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
