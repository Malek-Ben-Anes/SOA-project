<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run()
	{
		DB::table('users')->delete();

		for($i = 0; $i < 10; ++$i)
		{
			DB::table('users')->insert([
				'username' => 'Nom' . $i,
				'email' => 'email' . $i . '@blop.fr',
				'password' => bcrypt('password'),
				'country' => 'tunis',
				'city' => 'tunis',
				'address' => 'odc',
				'type' => 'freelancer'
			]);
		}
	}
}

