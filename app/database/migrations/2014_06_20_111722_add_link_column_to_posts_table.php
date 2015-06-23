<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkColumnToPostsTable extends Migration {

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
            $table->text('link')->after('content');
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
            $table->dropColumn('link');
        });
	}

}
