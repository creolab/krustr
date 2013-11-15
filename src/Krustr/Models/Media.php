<?php namespace Krustr\Models;

/**
 * Media items
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class Media extends Base {

	protected $table = 'media';

	/**
	 * User relationship
	 * @return Eloquent
	 */
	public function entry()
	{
		return $this->belongsTo('Krustr\Models\Entry');
	}

}
