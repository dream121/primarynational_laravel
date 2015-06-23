<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToAgentUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agent_queues', function(Blueprint $table)
		{
			//
			$table->boolean('status')->after('user_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agent_queues', function(Blueprint $table)
		{
			//
			$table->dropColumn('status');
		});
	}

}
