<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserFeatureLogTable extends Migration {

	public function up()
	{
		Schema::create('user_feature_log', function(Blueprint $table) {
			$table->increments('user_feature_id');
			$table->integer('user_id')->unsigned();
			$table->integer('feature_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('user_feature_log');
	}
}