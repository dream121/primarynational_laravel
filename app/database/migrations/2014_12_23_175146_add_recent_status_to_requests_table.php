<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecentStatusToRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('requests', function(Blueprint $table)
		{
			//
			$table->boolean('recent_status')->after('time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('requests', function(Blueprint $table)
		{
			//
			$table->dropColumn('recent_status');
		});
	}

}
