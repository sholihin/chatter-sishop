<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterPostTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chatter_discussion_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('markdown')->default(0);
            $table->boolean('locked')->default(0);
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('chatter_post');
    }
}
