<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFreelancerSkillTable extends Migration {

	public function up()
	{
		Schema::create('freelancer_skill', function(Blueprint $table) {
			$table->increments('freelancer_skill_id');
			$table->integer('skill_id')->unsigned();
			$table->integer('freelancer_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('freelancer_skill');
	}
}