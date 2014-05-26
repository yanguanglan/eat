<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('co_id');
			$table->integer('user_id');
			$table->integer('breakfast');
			$table->integer('lunch');
			$table->integer('dinner');
			$table->boolean('issms');
			$table->timestamp('worked_at')->nullable();
			$table->boolean('isapproval')->default(0);
			$table->text('reason')->nullable();
			$table->boolean('type')->default(0);
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
		Schema::drop('orders');
	}

}
