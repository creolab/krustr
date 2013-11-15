<?php namespace Krustr\Models;

use Config;
use Krustr\Repositories\Collections\EntryCollection;

/**
 * Model for content entries
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class Entry extends Base {

	/**
	 * Database table
	 *
	 * @var string
	 */
	protected $table = 'entries';

	/**
	 * Fields gurded from mass assignment
	 *
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * User relationship
	 *
	 * @return Eloquent
	 */
	public function author()
	{
		return $this->belongsTo('Krustr\Models\User');
	}

	/**
	 * Field relationship
	 *
	 * @return Eloquent
	 */
	public function fields()
	{
		return $this->hasMany('Krustr\Models\Field');
	}

	/**
	 * Only in a specific channel
	 *
	 * @param  Query $query
	 * @param  string $channel
	 * @return Query
	 */
	public function scopeInChannel($query, $channel)
	{
		return $query->where('channel', $channel);
	}

	/**
	 * Only published entries
	 *
	 * @return Query
	 */
	public function scopePublished($query)
	{
		return $query->where('status', 'published');
	}

}
