<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCriterionsTable extends Migration {

	public function up()
	{
		Schema::create('criterions', function(Blueprint $table) {
			$table->increments('criterion_id');
			$table->integer('challenge_id')->unsigned();
			$table->string('title');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('criterions');
	}
}