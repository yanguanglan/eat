<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('zh_CN');

		$Companys = Company::all();

		foreach($Companys as $Company) {
			foreach(range(1, 10) as $index)
			{
				User::create(array(
					'sn'=> $faker->ean8,
					'name'=> $faker->name,
					'password'=>Hash::make('password'),
					'phone'=>$faker->phoneNumber,
					'co_id'=> $Company->id,
					'fingerprint1'=>$faker->ean8,
					'fingerprint2'=>$faker->uuid,
					'iswork'=>$faker->boolean(75),
				));
			}
		}
	}

}