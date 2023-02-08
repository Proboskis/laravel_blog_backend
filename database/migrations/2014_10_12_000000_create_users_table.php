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
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->index();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('mobile_phone', 25)->unique()->nullable();
            $table->string('email', 50)->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->char('password', 20)->charset('binary');
//            $table->string('password', 40);
            $table->char('salt', 20)->charset('binary')->nullable();
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
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
