<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function(Blueprint $table) {
            $table->increments('user_id');
            $table->string('username');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('type', array('admin', 'enterprise', 'freelancer'))->nullable();
            $table->string('messages')->nullable();
            $table->string('notifications')->nullable();
            $table->rememberToken();
            $table->timestamps();
        
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

