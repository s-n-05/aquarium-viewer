<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_twitter_users', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('twitter_id');
            $table->string('twitter_name')->nullable();
            $table->string('twitter_username')->nullable();
            $table->timestamps();

            $table->primary(['twitter_id']);
            // $table->primary(['twitter_id'],'DUMMY_NAME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_twitter_users');
    }
}
