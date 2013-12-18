<?php namespace Krustr\Services\Navigation;

/**
 * Navigation item
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class Item {

	/**
	 * Item label
	 * @var string
	 */
	public $label;

	/**
	 * The item icon
	 * @var string
	 */
	public $icon;

	/**
	 * Order number in collection
	 * @var integer
	 */
	public $order;

	/**
	 * Link to item resource
	 * @var string
	 */
	public $href;

	/**
	 * Route to item resource
	 * @var string
	 */
	public $route;

	/**
	 * Sub items
	 * @var Collection
	 */
	public $children;

	/**
	 * Type of active mark
	 * @var string
	 */
	public $mark = 'loose';

	/**
	 * CSS class
	 * @var string
	 */
	public $class;

	/**
	 * User role
	 * @var string
	 */
	public $role;

	/**
	 * Initialize new navigation collection
	 *
	 * @param array $items
	 */
	public function __construct($data)
	{
		$this->label     = array_get($data, 'label', array_get($data, 'headline', array_get($data, 'title')));
		$this->icon      = array_get($data, 'icon');
		$this->class     = array_get($data, 'class');
		$this->li_class  = array_get($data, 'li_class');
		$this->route     = array_get($data, 'route');
		$this->mark      = array_get($data, 'mark', $this->mark);
		$this->order     = (int) array_get($data, 'order');
		$this->href      = array_get($data, 'href', $this->contentHref($data));
		$this->children  = $this->setChildren(array_get($data, 'children'));
		$this->role      = array_get($data, 'role', 'editor');
		$this->separated = (bool) array_get($data, 'separated', false);
	}

	/**
	 * Add children to item
	 *
	 * @param array $children
	 */
	public function setChildren($children = null)
	{
		if ($children)
		{
			if ( ! $children instanceof \Krustr\Services\Navigation\Collection)
			{
				$children = new \Krustr\Services\Navigation\Collection($children);
			}

			return $children;
		}

		return null;
	}

	/**
	 * Generate a href parama if this is a content entry item
	 * @param  array $data
	 * @return string
	 */
	public function contentHref($data)
	{
		if ($res = array_get($data, 'resource'))
		{
			$this->route = 'backend.content.'.$res.'.index';

			return route($this->route);
		}
		elseif ($route = array_get($data, 'route'))
		{
			return route($route);
		}

		return '#';
	}

	/**
	 * Check if item should be active
	 *
	 * @return string
	 */
	public function active()
	{
		// Check top level first
		$active = (app('route')->is($this->route));

		// Then check request
		if ( ! $active and $this->mark == 'loose')
		{
			$path = trim(str_replace(url(), '', $this->href), '/');

			// Check top level first
			$active = (app('request')->is($path) or app('request')->is($path.'*'));
		}

		return $active ? 'active' : null;
	}

	/**
	 * Check if item has a dropdown menu
	 * @return string
	 */
	public function dropdown()
	{
		if ($this->children)
		{
			return 'dropdown';
		}
	}

	/**
	 * Array representation of this item
	 *
	 * @return array
	 */
	public function toArray()
	{

	}

	/**
	 * Return property if exists
	 *
	 * @param  mixed $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if (isset($this->$key))
		{
			return $this->$key;
		}
	}

}
