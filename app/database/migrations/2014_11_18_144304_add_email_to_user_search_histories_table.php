<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailToUserSearchHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('user_search_histories', function(Blueprint $table)
		{
			//
			$table->string('email',255)->after('user_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('user_search_histories', function(Blueprint $table)
		{
			$table->dropColumn('email');
		});
	}

}
