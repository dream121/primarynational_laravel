<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {


	public function up()
	{
        Schema::create('users', function($table)
        {
            $table->increments('id');
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('email',100);
            $table->string('username',100);
            $table->string('password',60);
            $table->string('remember_token',100);
            $table->integer('role_id');
            $table->string('address_line1',100)->nullable();
            $table->string('address_line2',100)->nullable();
            $table->string('city',60)->nullable();
            $table->string('state',30)->nullable();
            $table->string('zip',10)->nullable();
            $table->dateTime('last_login')->nullable();
            $table->tinyInteger('active')->default(0);

            $table->timestamps();

        });
	}

	public function down()
	{
        Schema::drop('users');
	}

}
