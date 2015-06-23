<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSearchHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_search_histories', function($table)
		{
			//
			$table->increments('id');
			$table->integer('user_id');
			$table->string('search_name',128)->nullable();
			$table->text('search_link')->nullable();
			$table->string('search_type',16)->nullable();
			$table->boolean('email_alert');
			$table->string('email_interval',32)->nullable();
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
		Schema::drop('user_search_histories');
	}

}
