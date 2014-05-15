<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('password');
			$table->boolean('issms');
			$table->string('phone');
			$table->string('adminphone');
			$table->string('version');
			$table->string('remember_token')->nullable();
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
		Schema::drop('companies');
	}

}
