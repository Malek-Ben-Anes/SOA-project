<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEnterprisesTable extends Migration {

	public function up()
	{
		Schema::create('enterprises', function(Blueprint $table) {
			$table->integer('enterprise_id')->unsigned();
			$table->string('enterprise_name')->nullable();
			$table->integer('phone')->unsigned()->nullable();
			$table->string('logo', 100)->nullable();
			$table->text('description')->nullable();
			$table->string('enterprise_document', 100)->nullable();
			$table->integer('coins')->unsigned()->default(0);
			$table->boolean('premium')->default(false);
			$table->timestamp('timestamps');
			$table->string('country')->nullable();
			$table->string('city')->nullable();
			$table->string('address')->nullable();
			$table->integer('postal_code')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('enterprises');
	}
}