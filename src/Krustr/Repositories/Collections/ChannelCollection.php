<?php namespace Krustr\Repositories\Collections;

class ChannelCollection extends Collection {

	protected $entity = 'Krustr\Repositories\Entities\ChannelEntity';

	/**
	 * Initialize the collection with field definitions
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
	 * Get specific channel by name
	 *
	 * @param  string $name
	 * @return ChannelEntity
	 */
	public function find($name)
	{
		return $this->get($name, new $this->entity(array()));
	}

}
