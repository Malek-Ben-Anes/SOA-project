<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFreelancerProjectInterestTable extends Migration {

	public function up()
	{
		Schema::create('freelancer_project_interest', function(Blueprint $table) {
			$table->increments('freelancer_project_interest_id');
			$table->integer('freelancer_id')->unsigned();
			$table->integer('project_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('freelancer_project_interest');
	}
}