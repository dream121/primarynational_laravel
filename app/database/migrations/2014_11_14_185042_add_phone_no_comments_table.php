<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneNoCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('comments', function(Blueprint $table)
		{
			//
			$table->string('phone_no',40)->after('author_email')->nullable();
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
		Schema::table('comments', function(Blueprint $table)
		{
			$table->dropColumn('phone_no');
		});
	}

}
