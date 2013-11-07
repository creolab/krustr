<?php namespace Krustr\Seeds;

class DatabaseSeeder extends \Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\Eloquent::unguard();

		$this->call('\Krustr\Seeds\UsersTableSeeder');
		$this->call('\Krustr\Seeds\EntriesTableSeeder');
	}

}
