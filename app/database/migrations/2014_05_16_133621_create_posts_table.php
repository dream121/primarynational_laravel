<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    public function up()
    {
        Schema::create('posts', function($table)
        {
            $table->increments('id');
            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->text('type')->nullable();
            $table->text('content')->nullable();
            $table->integer('author_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('comment_status','20')->nullable();
            $table->bigInteger('comment_count')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::drop('posts');
    }
}
