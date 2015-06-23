<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientServedAndClientServeLimitToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			//
			$table->integer('client_serve_limit')->after('agent_order')->nullable();
			$table->integer('client_served')->after('client_serve_limit')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			//
			$table->dropColumn('client_serve_limit');
			$table->dropColumn('client_served');
		});
	}

}
