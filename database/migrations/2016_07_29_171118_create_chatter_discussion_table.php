<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterDiscussionTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_discussion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chatter_category_id')->unsigned()->default('1');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('color', 20)->nullable()->default('#232629');
            $table->integer('user_id')->unsigned();
            $table->boolean('sticky')->default(false);
            $table->integer('views')->unsigned()->default('0');
            $table->boolean('answered')->default(0);
            $table->timestamp('last_reply_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('chatter_discussion');
    }
}
