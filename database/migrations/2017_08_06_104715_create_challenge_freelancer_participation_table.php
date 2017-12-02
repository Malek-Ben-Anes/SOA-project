<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChallengeFreelancerParticipationTable extends Migration {

	public function up()
	{
		Schema::create('challenge_freelancer_participation', function(Blueprint $table) {
			$table->increments('freelancer_participation_id');
			$table->integer('freelancer_id')->unsigned();
			$table->integer('challenge_id')->unsigned();
			$table->string('document');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('challenge_freelancer_participation');
	}
}