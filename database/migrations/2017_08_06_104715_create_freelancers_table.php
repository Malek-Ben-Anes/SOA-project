<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFreelancersTable extends Migration {

	public function up()
	{
		Schema::create('freelancers', function(Blueprint $table) {
			$table->integer('freelancer_id')->unsigned();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('pseudonym')->nullable();
			$table->string('short_description')->nullable();
			$table->text('description')->nullable();
			$table->integer('phone')->unsigned()->nullable();
			$table->string('image', 40)->nullable();
			$table->string('background_image', 40)->nullable();
			$table->string('freelancer_curriculum_vitae', 20)->nullable();
			$table->integer('premium')->default(0);
			$table->integer('coins')->unsigned()->default(0);
			$table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->integer('postal_code')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('freelancers');
	}
}