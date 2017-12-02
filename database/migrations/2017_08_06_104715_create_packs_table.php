<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePacksTable extends Migration {

	public function up()
	{
		Schema::create('packs', function(Blueprint $table) {
			$table->increments('pack_id');
			$table->string('title', 50);
			$table->float('price');
			$table->integer('coins');
			$table->string('description')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('packs');
	}
}