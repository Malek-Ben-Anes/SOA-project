<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChallengeCommentsTable extends Migration {

	public function up()
	{
		Schema::create('challenge_comments', function(Blueprint $table) {
			$table->increments('challenge_comment_id');
			$table->integer('challenge_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->text('comment');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('challenge_comments');
	}
}