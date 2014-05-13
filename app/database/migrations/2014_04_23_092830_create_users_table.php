<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('sn');
			$table->string('name');
			$table->string('password');
			$table->string('phone');
			$table->integer('co_id');
			$table->integer('fingerprint1')->nullable;
			$table->binary('fingerprint2')->nullable();
			$table->boolean('iswork');
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
		Schema::drop('users');
	}

}
