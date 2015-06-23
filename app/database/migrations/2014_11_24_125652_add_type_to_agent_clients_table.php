<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToAgentClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agent_clients', function(Blueprint $table)
		{
			//
			$table->string('type',10)->after('agent_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agent_clients', function(Blueprint $table)
		{
			//
			$table->dropColumn('type');
		});
	}

}
