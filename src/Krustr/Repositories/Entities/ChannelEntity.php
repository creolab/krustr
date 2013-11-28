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
		$this->fields = new \Krustr\Repositories\Collections\FieldCollection;

		// And get all fields
		foreach ($this->groups as $groupName => &$group)
		{
			foreach ($group->fields as $name => &$field)
			{
				$this->fields[$name] = $field;
			}
		}

		// Get all fields and groups, and remove array from data
		array_forget($config, 'fields');
		array_forget($config, 'groups');

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
