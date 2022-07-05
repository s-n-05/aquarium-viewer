<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tweet_id')->unique();
            $table->string('tweet_author_id')->nullable();
            $table->string('tweet_created_at')->nullable();
            $table->string('tweet_lang')->nullable();
            $table->string('tweet_text')->nullable();
            $table->string('tweet_media_url_1')->nullable();
            $table->string('tweet_media_url_2')->nullable();
            $table->string('tweet_media_url_3')->nullable();
            $table->string('tweet_media_url_4')->nullable();
            $table->string('tweet_media_url_5')->nullable();
            $table->string('tweet_media_url_1_local')->nullable();
            $table->string('tweet_media_url_2_local')->nullable();
            $table->string('tweet_media_url_3_local')->nullable();
            $table->string('tweet_media_url_4_local')->nullable();
            $table->string('tweet_media_url_5_local')->nullable();
            $table->string('tweet_aquarium_hashtag')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_posts');
    }
}
