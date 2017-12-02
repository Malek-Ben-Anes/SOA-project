<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	public function up()
	{
		Schema::create('transactions', function(Blueprint $table) {
			$table->increments('transaction_id');
			$table->integer('user_id')->unsigned();
			$table->integer('pack_id')->unsigned();
			$table->string('transactionToken', 256);
			$table->float('price');
			$table->integer('status')->default('0');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('transactions');
	}
}