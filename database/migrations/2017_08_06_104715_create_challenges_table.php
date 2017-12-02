<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChallengesTable extends Migration {

	public function up()
	{
		Schema::create('challenges', function(Blueprint $table) {
			$table->increments('challenge_id');
			$table->integer('project_id')->unsigned();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->string('challenge_document')->nullable();
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->integer('winner_number')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('challenges');
	}
}