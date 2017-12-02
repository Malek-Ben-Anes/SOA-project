<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectSkillRequiredTable extends Migration {

	public function up()
	{
		Schema::create('project_skill_required', function(Blueprint $table) {
			$table->increments('skill_required_id');
			$table->integer('project_id')->unsigned();
			$table->integer('skill_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('project_skill_required');
	}
}