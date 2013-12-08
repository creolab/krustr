<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->nullable()->index();
			$table->integer('entry_id')->nullable()->index();
			$table->string('field_id')->nullable()->index();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->string('path')->nullable();
			$table->string('type', 20)->default('item'); // Can be 'item' or 'collection'
			$table->integer('order')->nullable();
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
		Schema::drop('media');
	}

}
