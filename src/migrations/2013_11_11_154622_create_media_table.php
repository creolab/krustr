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
			$table->integer('parent_id');
			$table->integer('field_id')->nullable();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->string('path');
			$table->string('type', 20)->default('item'); // Can be 'item' or 'collection'
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
