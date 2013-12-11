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
	public function __construct(array $config, $entry = null)
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

		// Add entry specific fields if needed
		if ($entry) $this->addEntryFields($entry);

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

	/**
	 * Return field groups and field for entry by slug
	 * @return void
	 */
	public function addEntryFields($entry)
	{
		if ($this->entry_fields)
		{
			// Get fields by entry slug
			$entryKey    = str_replace("-", "_", $entry->slug);
			$entryFields = array_get($this->entry_fields, $entryKey);

			if ($entryFields)
			{
				foreach ($entryFields as $groupKey => $fields)
				{
					// Add field to existing group or create new one
					if ($this->groups->has($groupKey))
					{
						foreach ($fields as $key => $field)
						{
							$this->groups[$groupKey]->fields->put($key, $f = new FieldEntity($field));
							$this->fields->put($key, $f);
						}
					}
					else
					{
						$this->groups->put($groupKey, new FieldGroupEntity($fields));

						// Also add the fields to global list
						foreach ($this->groups[$groupKey]->fields as $newKey => $newField)
						{
							$this->fields->put($newKey, $newField);
						}
					}
				}
			}

			array_forget($this->data, 'entry_fields');
		}
	}

}
