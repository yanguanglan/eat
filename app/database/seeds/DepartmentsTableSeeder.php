<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class DepartmentsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('zh_CN');
        $Companys = Company::all();

        foreach ($Companys as $Company) {
        	foreach(range(1, 10) as $index)
			{
				Department::create(array(
					'name'=>$faker->text(10),
			        'starttime'=>$faker->dateTime(),
			        'endtime'=>$faker->dateTime(),
					'co_id'=>$Company->id,
				));
			}
        }
		
	}

}