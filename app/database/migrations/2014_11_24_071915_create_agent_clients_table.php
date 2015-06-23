<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('agent_clients', function($table)
		{
			//
			$table->increments('id');
			$table->integer('client_id')->nullable();
			$table->string('ip_address',60)->nullable();
			$table->integer('agent_id')->nullable();
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
		//
		Schema::drop('agent_clients');
	}

}
