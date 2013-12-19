<?php namespace Krustr\Models;

class Field extends Base {

	protected $table = 'fields';

	/**
	 * Entry relationship
	 * @return Eloquent
	 */
	public function entry()
	{
		return $this->belongsTo('Krustr\Models\Entry');
	}

}
