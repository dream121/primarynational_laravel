<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function($table)
        {
            $table->increments('id');
            $table->integer('post_id');
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_ip');
            $table->text('author_url');
            $table->integer('approved');
            $table->integer('parent');
            $table->integer('user_id');
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
		Schema::drop('comments');
	}

}
