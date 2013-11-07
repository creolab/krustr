<?php namespace Krustr\Repositories\Entities;

use String;

abstract class Entity {

	/**
	 * Contains all entity data
	 * @var array
	 */
	protected $data = array();

	/**
	 * Initialize entity
	 * @param array $config
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Get entity property
	 * @param  mixed $key
	 * @return mixed
	 */
	public function get($key)
	{
		if (isset($this->data[$key]))
		{
			return $this->data[$key];
		}
		elseif (method_exists($this, $method = 'get'.camel_case($key).'Attribute'))
		{
			return call_user_func(array($this, $method));
		}

		return null;
	}

	/**
	 * Magic helper
	 * @param  mixed $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Get data as JSON
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toArray(), $options);
	}

	/**
	 * Get data as array
	 * @param  int  $options
	 * @return string
	 */
	public function toArray($options = 0)
	{
		return array_map(function($value)
		{
			return $value instanceof ArrayableInterface ? $value->toArray() : $value;

		}, $this->data);
	}

}
