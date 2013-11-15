<?php namespace Krustr\Seeds;

use Datetime, DB;

class EntriesTableSeeder extends \Seeder
{
	public function run()
	{
		// ! Articles
		$entry = DB::table('entries')->insertGetId(array(
			'title'        => 'First entry',
			'slug'         => 'first-entry',
			'body'         => '<p>Lorem ipsum</p>',
			'channel'      => 'blog',
			'author_id'    => 1,
			'status'       => 'published',
			'created_at'   => new Datetime,
			'updated_at'   => new Datetime,
			'published_at' => new Datetime,
		));
		DB::table('fields')->insert(array('entry_id' => $entry, 'name' => 'terms', 'value' => 'Lorem ipsum', 'type' => 'textarea'));
		$entry = DB::table('entries')->insertGetId(array(
			'title'        => 'Another one',
			'slug'         => 'another-one',
			'body'         => '<p>Lorem ipsum dolorem sit</p>',
			'channel'      => 'blog',
			'status'       => 'published',
			'author_id'    => 1,
			'created_at'   => new Datetime,
			'updated_at'   => new Datetime,
			'published_at' => new Datetime,
		));
		$entry = DB::table('entries')->insertGetId(array(
			'title'        => 'Latest post',
			'slug'         => 'latest-post',
			'body'         => '<p>Lorem ipsum dolorem sit</p>',
			'channel'      => 'blog',
			'status'       => 'draft',
			'author_id'    => 1,
			'created_at'   => new Datetime,
			'updated_at'   => new Datetime,
			'published_at' => null,
		));
		DB::table('fields')->insert(array('entry_id' => $entry, 'name' => 'terms', 'value' => 'Lorem ipsum 333333333', 'type' => 'textarea'));

		// ! Pages
		$entry = DB::table('entries')->insertGetId(array(
			'title'        => 'Welcome',
			'slug'         => 'welcome',
			'body'         => '<h3>Krustr</h3><p class="lead">Creative Administration</p>',
			'channel'      => 'pages',
			'status'       => 'published',
			'author_id'    => 1,
			'home'         => 1,
			'created_at'   => new Datetime,
			'updated_at'   => new Datetime,
			'published_at' => new Datetime,
		));
		$entry = DB::table('entries')->insertGetId(array(
			'title'        => 'About us',
			'slug'         => 'about-us',
			'body'         => '<p>Lorem ipsum</p>',
			'channel'      => 'pages',
			'status'       => 'published',
			'author_id'    => 1,
			'created_at'   => new Datetime,
			'updated_at'   => new Datetime,
			'published_at' => new Datetime,
		));
		$entry = DB::table('entries')->insertGetId(array(
			'title'        => 'Contact',
			'slug'         => 'contact',
			'body'         => '<p>Lorem ipsum dolorem sit</p>',
			'channel'      => 'pages',
			'status'       => 'published',
			'author_id'    => 1,
			'created_at'   => new Datetime,
			'updated_at'   => new Datetime,
			'published_at' => new Datetime,
		));
	}
}
