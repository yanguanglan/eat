<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CompaniesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('zh_CN');

		foreach(range(1, 10) as $index)
		{
			Company::create(
				array(
					'name'=>$faker->company,
					'password'=>Hash::make('password'),
					'issms'=>$faker->boolean(30),
					'phone'=>$faker->phoneNumber,
					)
			);
		}
	}

}