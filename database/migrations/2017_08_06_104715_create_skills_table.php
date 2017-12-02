<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkillsTable extends Migration {

	public function up()
	{
		Schema::create('skills', function(Blueprint $table) {
			$table->increments('skill_id');
			$table->string('title', 20);
		});
	}

	public function down()
	{
		Schema::drop('skills');
	}
}