<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('notification_id');
			$table->string('title');
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}