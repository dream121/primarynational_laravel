<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// requests table for buy sell and finance page visitor feeedback
		Schema::create('requests', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('agent_id');
			$table->string('type',16)->nullable();
			$table->string('first_name',64)->nullable();
			$table->string('last_name',64)->nullable();
			$table->string('email',64)->nullable();
			$table->string('phone_number',32)->nullable();
			$table->dateTime('move_in')->nullable();
			$table->boolean('pre_approved');
			$table->string('location')->nullable();
			$table->double('price', 15, 2);
			$table->double('size', 15, 2);
			$table->integer('bedrooms');
			$table->integer('bathrooms');
			$table->string('style',255)->nullable();
			$table->boolean('sell_before_moving');
			$table->text('others');
			$table->dateTime('date_of_sell')->nullable();
			$table->string('relocating')->nullable();
			$table->boolean('recent_improvements');
			$table->string('purchase_reason',255)->nullable();
			$table->string('get_pre_approved',255)->nullable();
			$table->string('get_refinanced',255)->nullable();
			$table->boolean('apply_home_loan');
			$table->string('attend_homebuyer_seminar',255)->nullable();
			$table->text('comments')->nullable();
			$table->string('way_of_contact',255)->nullable();
			$table->dateTime('time_to_reach')->nullable();
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
		Schema::drop('requests');
	}

}
