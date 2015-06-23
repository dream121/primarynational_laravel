<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageLinkToPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('posts', function(Blueprint $table)
		{
			//
			$table->text('image_link_1')->after('status')->nullable();
			$table->text('image_link_2')->after('image_link_1')->nullable();
			$table->text('image_link_3')->after('image_link_2')->nullable();
			$table->text('image_link_4')->after('image_link_3')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('posts', function(Blueprint $table)
		{
			//
			$table->dropColumn('image_link_1');
			$table->dropColumn('image_link_2');
			$table->dropColumn('image_link_3');
			$table->dropColumn('image_link_4');
		});
	}

}
