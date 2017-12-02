<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFreelancerProfileUnblockedTable extends Migration {

	public function up()
	{
		Schema::create('freelancer_profile_unblocked', function(Blueprint $table) {
			$table->increments('freelancer_profile_unblocked_id');
			$table->integer('freelancer_id')->unsigned();
			$table->integer('enterprise_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('freelancer_profile_unblocked');
	}
}