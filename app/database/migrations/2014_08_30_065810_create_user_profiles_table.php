<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	 	Schema::create('user_profiles', function($table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('agent_id');
            $table->string('designation',100)->nullable();
            $table->string('tagline')->nullable();
            $table->text('biography')->nullable();
            $table->string('office_name')->nullable();
            $table->string('office_address_line1')->nullable();
            $table->string('office_address_line2')->nullable();
            $table->string('photo')->nullable();;
            $table->timestamps();

        });
	}

	public function down()
	{
        Schema::drop('user_profiles');
	}

}
