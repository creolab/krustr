<?php namespace Krustr\Repositories\Entities;

class ChannelEntity extends Entity {

	/**
	 * Custom field in channel
	 * @var array
	 */
	public $fields = array();

	/**
	 * Initialize entity
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		// Get all groups
		$this->groups = new \Krustr\Repositories\Collections\FieldGroupCollection((array) array_get($config, 'groups'));
		$this->fields = new \Krustr\Repositories\Collections\FieldCollection(array());

		// And get all fields
		foreach ($this->groups as $groupName => &$group)
		{
			foreach ($group->fields as $name => &$field)
			{
				$this->fields->put($name, $field);
			}
		}

		// Get all fields and remove array from data
		$this->fields = new \Krustr\Repositories\Collections\FieldCollection((array) array_get($config, 'fields'));
		array_forget($config, 'fields');

		// Rest of the data
		$this->data = $config;
	}

	/**
	 * Get field object
	 * @param  string $name
	 * @return FieldEntity
	 */
	public function field($name)
	{
		return $this->fields->get($name);
	}

}
