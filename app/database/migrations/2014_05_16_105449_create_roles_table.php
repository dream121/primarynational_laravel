<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {


    public function up()
    {
        Schema::create('roles', function($table)
        {
            $table->increments('id');
            $table->string('name',100);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::drop('roles');
    }

}
