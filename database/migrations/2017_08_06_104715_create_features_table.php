<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeaturesTable extends Migration {

	public function up()
	{
		Schema::create('features', function(Blueprint $table) {
			$table->increments('feature_id');
			$table->string('title');
			$table->string('description');
			$table->integer('price_coins');
			$table->integer('type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('features');
	}
}