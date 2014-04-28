<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CompaniesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('NewsTableSeeder');
		$this->call('DepartmentsTableSeeder');
		$this->call('OrdersTableSeeder');

	}

}
