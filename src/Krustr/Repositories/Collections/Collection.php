<?php namespace Krustr\Repositories\Collections;

class Collection extends \Illuminate\Support\Collection {

	/**
	 * Entity class
	 *
	 * @var string
	 */
	protected $entity;

	/**
	 * Initialize the collection
	 *
	 * @param array $items
	 */
	public function __construct(array $items = array())
	{
		// Register all channel in collection
		foreach ($items as $key => $item)
		{
			$this->items[$key] = new $this->entity($item);
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
			$items[] = $item->toArray();
		}

		return $items;
	}

}
