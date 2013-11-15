<?php namespace Krustr\Repositories\Entities;

use Carbon\Carbon;
use Krustr\Repositories\Collections\FieldCollection;

/**
 * Single entity for content entry
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class EntryEntity extends Entity {

	/**
	 * Initialize the collection
	 *
	 * @param array $items
	 */
	public function __construct($data)
	{
		if (isset($data['author']))
		{
			$data['author'] = new UserEntity((array) $data['author']);
			$data['fields'] = new FieldCollection($data['fields']);
		}

		parent::__construct($data);
	}

	/**
	 * Get an entry field
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function field($key)
	{
		if (is_array($key)) $key = $key[0];

		foreach ($this->fields as $field)
		{
			if ($key == $field->name)
			{
				// Date field
				if     ($field->type == 'date')     return Carbon::createFromTimeStamp(strtotime($field->value));
				elseif ($field->type == 'datetime') return Carbon::createFromTimeStamp(strtotime($field->value));
				else                                return $field->value;
			}
		}
	}

	/**
	 * Returns date for entry
	 *
	 * @return string
	 */
	public function getDateAttribute()
	{
		if ($this->published_at) return $this->published_at;
		else                     return $this->updated_at;
	}

}
