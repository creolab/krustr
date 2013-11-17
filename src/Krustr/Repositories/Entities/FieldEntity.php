<?php namespace Krustr\Repositories\Entities;

use App, View;
use Krustr\Forms\Fields\FieldException;

class FieldEntity extends Entity {

	/**
	 * Init new field entity
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		// Add data to field object
		$this->data = $data;

		// Find field definition
		$definition = app("krustr.fields")->get($data['type']);

		// Merge the data
		if ($definition) $this->data = array_merge($definition->toArray(), $this->data);
	}

	/**
	 * Render the fields view
	 *
	 * @return View
	 */
	public function render($value = null)
	{
		// If object was instantiated, run redering
		if ($this->instance()) return $this->instance()->render($value);
	}

	/**
	 * Save field value
	 *
	 * @return boolean
	 */
	public function save($data = null)
	{
		// If object was instantiated, save it
		return $this->instance()->save($data);
	}

	/**
	 * Return the fields value
	 *
	 * @return mixed
	 */
	public function value()
	{
		// If object was instantiated, save it
		return $this->instance()->value();
	}

	/**
	 * Get field instance
	 *
	 * @return Krustr\Forms\Field\Field
	 */
	protected function instance()
	{
		$className = $this->class;

		// Check if class exists
		if ( ! class_exists($className)) throw new FieldException("The class [$className] does not exist.");

		// Try to instantiate the field object
		if ( ! $this->instance)
		{
			$this->data['instance'] = new $className($this, $this->value);
		}

		return $this->instance;
	}

}
