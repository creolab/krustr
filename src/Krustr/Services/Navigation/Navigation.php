<?php namespace Krustr\Services\Navigation;

use Illuminate\Foundation\Application;

class Navigation {

	/**
	 * All navigation collections
	 * @var array
	 */
	protected $collections = array();

	/**
	 * IoC container
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Init navigation environment
	 * @param Application  $app
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Add new collection
	 *
	 * @param string $name
	 * @param array  $items
	 */
	public function add($name, $data)
	{
		if ( ! isset($this->collections[$name]))
		{
			if ($items = array_get($data, 'items'))
			{
				unset($data['items']);
				return $this->collections[$name] = $this->app['krustr.navigation.'.$name] = new Collection($items, $data);
			}
			else
			{
				throw new \Krustr\Exception("No items passed to navigation collection of name '$name'.", 1);
			}
		}
		else
		{
			throw new \Krustr\Exception("Navigation collection by the name '$name' already exists.", 1);
		}
	}

	/**
	 * Render a collection
	 *
	 * @param  string $name
	 * @return string
	 */
	public function render($name)
	{
		if (isset($this->collections[$name]))
		{
			return $this->collections[$name]->render();
		}
	}

	/**
	 * Render sub navigation in collection
	 *
	 * @param  string $name
	 * @return string
	 */
	public function sub($name)
	{
		if (isset($this->collections[$name]))
		{
			return $this->collections[$name]->sub();
		}
	}

}
