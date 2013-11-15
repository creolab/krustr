<?php namespace Krustr\Repositories\Entities;

use App, View;

class FieldTypeEntity extends Entity {

	/**
	 * Field definition
	 * @var FieldTypeEntity
	 */
	protected $definition;

	/**
	 * Field value, passed when creating form
	 * @var mixed
	 */
	protected $value;

	/**
	 * The actual field object
	 * @var Forms\Fields\Field;
	 */
	protected $object;

	/**
	 * Initialize field entity
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		echo '<pre>'; print_r(var_dump($config)); echo '</pre>';
		echo '<pre>'; print_r(var_dump(app('krustr.fields'))); echo '</pre>';
		die();

		// Get field definition
		$definitions      = App::make('krustr.fields');
		$this->definition = $definitions->get(array_get($config, 'type'));

		// Add to entity
		$this->data = $config;
	}

	/**
	 * Render the fields view
	 * @return View
	 */
	public function render($value = null)
	{
		// Try to instantiate the field object
		if ( ! $this->object) $this->object = new $this->definition->class($this, $value);

		// If object was instantiated, run redering
		if ($this->object) return $this->object->render($value);
	}

	/**
	 * Save field value
	 * @return boolean
	 */
	public function save($data = null)
	{
		// Try to instantiate the field object
		if ( ! $this->object) $this->object = new $this->definition->class($this);

		// If object was instantiated, run redering
		if ($this->object) return $this->object->save($data);
	}

}
