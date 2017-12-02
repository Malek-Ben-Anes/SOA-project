<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFreelancerCriterionEvaluationTable extends Migration {

	public function up()
	{
		Schema::create('freelancer_criterion_evaluation', function(Blueprint $table) {
			$table->increments('freelancer_evalution_id');
			$table->integer('freelancer_id')->unsigned();
			$table->integer('criterion_id')->unsigned();
			$table->float('mark');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('freelancer_criterion_evaluation');
	}
}