<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run()
	{
		DB::table('users')->delete();

		for($i = 0; $i < 10; ++$i)
		{
			DB::table('users')->insert([
				'username' => 'username' . $i,
				'email' => 'email' . $i . '@blop.fr',
				'password' => bcrypt('password'),
				'address' => 'Rue du Lac Biwa, Tunis, Tunisie',
				'type' => 'freelancer'
			]);
		}
	}
}

