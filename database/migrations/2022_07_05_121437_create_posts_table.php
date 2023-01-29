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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('post_parent_id')->unsigned()->nullable()->default(DB::raw('NULL'));
            $table->foreign('post_parent_id')->references('id')->on('posts');
            $table->string('title', 25);
            $table->string('meta_title', 100);
            $table->string('slug', 100);
            $table->tinyInteger('reading_time');
            $table->tinyText('summary');
            $table->boolean('published')->default('0');
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->datetime('published_at')->nullable();
            $table->text('content');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
