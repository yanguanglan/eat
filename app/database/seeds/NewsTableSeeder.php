<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class NewsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('zh_CN');
		$Companys = Company::all(); 
		foreach ($Companys as $Company) {
			$Users = User::where('co_id', $Company->id)->get();
			# code...
			foreach(range(1, 10) as $index)
			{
				News::create(
					array(
						'title'=>$faker->text(15),
						'content'=>$faker->text(200),
						'expirationdate'=>$faker->date(),
						'co_id'=>$Company->id,
						'user_id'=>$Users[$index-1]->id,
						)
				);
			}
		}
	}

}