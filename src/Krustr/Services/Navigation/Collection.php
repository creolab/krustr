<?php namespace Krustr\Services\Navigation;

class Collection extends \Illuminate\Support\Collection {

	/**
	 * Extra configuration data for the collection
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Initialize new navigation collection
	 *
	 * @param array $items
	 * @param array $data
	 */
	public function __construct($items = array(), $data = null)
	{
		$this->data = $data;

		// Create item instances
		foreach ($items as $item)
		{
			$this->items[] = new Item($item);
		}
	}

	/**
	 * Render the collection
	 *
	 * @return string
	 */
	public function render()
	{
		return app('view')->make($this->data('view'), $this->toArray());
	}

	/**
	 * Get collection property
	 *
	 * @param  mixed $key
	 * @return mixed
	 */
	public function data($key)
	{
		if (isset($this->data[$key]))
		{
			return $this->data[$key];
		}
	}

	/**
	 * Return current active sub navigation
	 *
	 * @return string
	 */
	public function sub()
	{
		foreach ($this->items as $item)
		{
			if ($item->active() and $item->children)
			{
				return app('view')->make($this->data('subview'), $item->children->toArray());
			}
		}
	}

	/**
	 * Array representation of collection
	 *
	 * @return array
	 */
	public function toArray()
	{
		$data          = $this->data;
		$data['items'] = $this->items;

		return $data;
	}

}
