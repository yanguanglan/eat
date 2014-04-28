<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('zh_CN');
 		$Companys = Company::all();

		foreach($Companys as $Company) {
			$Users = User::where('co_id', $Company->id)->get();
			foreach(range(1, 10) as $index)
			{
				Order::create(
					array('co_id'=> $Company->id,
					'user_id'=> $Users[$index-1]->id,
					'breakfast'=> $faker->randomDigit(),
					'lunch'=>$faker->randomDigit(),
					'dinner'=>$faker->randomDigit(),
					'issms'=>$faker->boolean(30),
					)
				);
			}
	   }
	}

}