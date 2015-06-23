<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteSettingsTable extends Migration {

    public function up()
    {
        Schema::create('site_settings', function($table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('meta_keyword');
            $table->text('meta_description');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::drop('site_settings');
    }

}
