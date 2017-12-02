<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevicesTable extends Migration {

	public function up()
	{
		Schema::create('devices', function(Blueprint $table) {
			$table->increments('device_id');
			$table->integer('user_id')->unsigned();
			$table->string('deviceToken', 50);
			$table->string('platform', 20);
			$table->string('timestamps');
		});
	}

	public function down()
	{
		Schema::drop('devices');
	}
}