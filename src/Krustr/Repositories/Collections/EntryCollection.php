<?php namespace Krustr\Repositories\Collections;

use Krustr\Repositories\Entities\EntryEntity;

class EntryCollection extends Collection {

	protected $entity = 'Krustr\Repositories\Entities\EntryEntity';

	/**
	 * Initialize the collection
	 *
	 * @param array $items
	 */
	public function __construct($items)
	{
		foreach ($items as $item)
		{
			$this->items[] = new EntryEntity($item);
		}
	}

	/**
	 * Get the collection of items as a plain array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		$items = array();

		foreach ($this->items as $item)
		{
			$items[] = $item;
		}

		return $items;
	}

}
