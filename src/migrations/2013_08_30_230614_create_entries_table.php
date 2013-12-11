<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('author_id')->index();
			$table->string('title');
			$table->string('slug')->index();
			$table->text('body')->nullable();
			$table->string('channel', 20)->default('pages')->index();
			$table->string('status', 20)->default('draft')->index();
			$table->integer('home')->index();
			$table->string('meta_title')->nullable();
			$table->string('meta_keywords')->nullable();
			$table->text('meta_description')->nullable();
			$table->dateTime('published_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('entries');
	}

}
