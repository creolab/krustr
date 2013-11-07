<?php namespace Krustr\Seeds;

use Carbon, Datetime, DB, Hash;

class UsersTableSeeder extends \Seeder
{
	public function run()
	{
		DB::table('users')->insert(array(
			'username'   => 'bstrahija',
			'email'      => 'bstrahija@gmail.com',
			'password'   => Hash::make('123456'),
			'first_name' => 'Boris',
			'last_name'  => 'Strahija',
			'created_at' => new Datetime,
			'updated_at' => new Datetime,
		));
	}
}
