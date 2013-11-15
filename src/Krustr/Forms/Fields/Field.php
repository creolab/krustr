<?php namespace Krustr\Forms\Fields;

use View;

/**
 * Base class for various content fields
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
abstract class Field implements FieldInterface {

	/**
	 * Data container
	 * @var array
	 */
	protected $data;

	/**
	 * Field repo dependency
	 * @var FieldRepositoryInterface
	 */
	protected $repo;

	/**
	 * Media repo dependency
	 * @var MediaRepositoryInterface
	 */
	protected $media;

	/**
	 * Initiliaze the field
	 *
	 * @param mixed $data
	 */
	public function __construct(&$field, $value = null)
	{
		// Dependencies
		$this->repo  = \App::make('Krustr\Repositories\Interfaces\FieldRepositoryInterface');
		$this->media = \App::make('Krustr\Repositories\Interfaces\MediaRepositoryInterface');

		// Get passed data
		$this->data = $field->data;

		// Get value and field object
		$this->set('value', $value);
	}

	/**
	 * Renders the field view
	 *
	 * @return View
	 */
	public function render($value = null)
	{
		if ($value) $this->value = $value;

		if ($this->view)
		{
			$html = View::make($this->view, array(
				'field' => $this,
				'value' => $this->value,
			));

			return $html;
		}
	}

	/**
	 * Save the field value
	 *
	 * @return mixed
	 */
	public function save($value = null)
	{
		return $value;
	}

	/**
	 * Return field value
	 *
	 * @return mixed
	 */
	public function value()
	{
		return $this->value;
	}

	/**
	 * Set a field data value
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 * Magic helper
	 * @param  mixed $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if (isset($this->$key))                                                     return $this->$key;
		elseif (isset($this->data[$key]))                                           return $this->data[$key];
		elseif (method_exists($this, $method = 'get'.camel_case($key).'Attribute')) return call_user_func(array($this, $method));
	}

}
