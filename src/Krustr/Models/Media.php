<?php namespace Krustr\Models;

class Media extends Base {

	protected $table = 'media';

	/**
	 * Entry relationship
	 * @return Eloquent
	 */
	public function entry()
	{
		return $this->belongsTo('Krustr\Models\Entry');
	}

}
