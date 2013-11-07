<?php namespace Krustr\Forms\Fields;

use View;

/**
 * Base class for various content fields
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
abstract class Field implements FieldInterface {

	/**
	 * The field entity
	 *
	 * @var Repositories\FieldEntity;
	 */
	protected $field;

	/**
	 * Value for the field
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Initiliaze the field
	 *
	 * @param mixed $data
	 */
	public function __construct($field, $value = null)
	{
		$this->value = $value;
		$this->field = $field;
	}

	/**
	 * Renders the field view
	 *
	 * @return View
	 */
	public function render($value = null)
	{
		$this->value = $value;

		if ($this->field)
		{
			$view = $this->field->view;
			$html = View::make($view, array(
				'field' => $this->field,
				'value' => $this->value(),
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
	 * Get field definition
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function definition($key = null)
	{
		return $this->field->definition->get($key);
	}

	/**
	 * Return value of field
	 *
	 * @return mixed
	 */
	public function value()
	{
		return $this->value;
	}

	/**
	 * Get a field param
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if     (isset($this->$key))             return $this->$key;
		elseif (isset($this->field->$key))      return $this->field->$key;
		elseif (isset($this->definition->$key)) return $this->definition->$key;
	}

}
