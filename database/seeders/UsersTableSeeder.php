<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Role::create(['name' => Role::SUPER_ADMIN]);
		Role::create(['name' => Role::ADMIN]);
		Role::create(['name' => Role::USER]);

		$user = User::create([
			'name' => 'hexiquio',
			'email' => 'hexiquiogv@email.com',
			'nombre' => 'hexiquio',
			'paterno' => 'gomez',
			'materno' => 'de valle',
			'password' => bcrypt('hexiquiogv@email.com')
		]);

		$user->assignRole( Role::SUPER_ADMIN );
		$user->assignRole( Role::ADMIN );

		

	}
}