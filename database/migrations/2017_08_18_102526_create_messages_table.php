<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	public function up()
	{
		Schema::create('messages', function(Blueprint $table) {
			$table->increments('message_id');
			$table->integer('receiver_id')->unsigned();
			$table->integer('sender_id')->unsigned();
			$table->text('content');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('messages');
	}
}