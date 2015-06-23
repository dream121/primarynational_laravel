<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommentStatusColumnNotnullToNullableInPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('posts', function($table)
        {
            $table->dropColumn('comment_status');
        });

        Schema::table('posts', function($table)
        {
            $table->string('comment_status',20)->nullable()->after('status');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{


        Schema::table('posts', function($table)
        {
            $table->dropColumn('comment_status');
        });

        Schema::table('posts', function($table)
        {
            $table->string('comment_status',20)->after('status');
        });
	}

}
