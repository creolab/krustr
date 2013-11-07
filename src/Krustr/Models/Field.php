<?php namespace Krustr\Models;

/**
 * Field content
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class Field extends Base {

	protected $table = 'fields';

	/**
	 * User relationship
	 * @return Eloquent
	 */
	public function entry()
	{
		return $this->belongsTo('Krustr\Models\Entry');
	}

}
