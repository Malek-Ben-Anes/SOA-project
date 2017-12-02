<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserNotificationTable extends Migration {

	public function up()
	{
		Schema::create('user_notification', function(Blueprint $table) {
			$table->increments('user_notification_id');
			$table->integer('notified_id')->unsigned();
			$table->integer('notifier_id')->unsigned();
			$table->integer('notification_id')->unsigned();
			$table->boolean('viewed')->default(false);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('user_notification');
	}
}