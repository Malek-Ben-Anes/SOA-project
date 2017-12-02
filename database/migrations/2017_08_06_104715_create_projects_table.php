<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

	public function up()
	{
		Schema::create('projects', function(Blueprint $table) {
			$table->increments('project_id');
			$table->integer('enterprise_id')->unsigned();
			$table->string('title', 50);
			$table->text('description');
			$table->float('budget');
			$table->datetime('ending_date') ;
			$table->boolean('open')->default(true);
			$table->boolean('sponsored')->default(false);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('projects');
	}
}