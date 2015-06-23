<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddListingIdToRequestsTable extends Migration {

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
			$table->string('listing_id',10)->after('agent_id')->nullable();
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
			$table->dropColumn('listing_id');
		});
	}

}
