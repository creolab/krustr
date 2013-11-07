<?php namespace Krustr\Repositories;

use Krustr\Models\Entry;
use Krustr\Models\Field;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;

class FieldDbRepository implements Interfaces\FieldRepositoryInterface {

	/**
	 * Channels repo
	 * @var ChannelRepositoryInterface
	 */
	protected $channels;

	/**
	 * Init dependencies
	 * @param ChannelRepositoryInterface $channels
	 */
	public function __construct(ChannelRepositoryInterface $channels)
	{
		$this->channels = $channels;
	}

	/**
	 * Get all fields for entry
	 *
	 * @param  integer $entryId
	 * @return mixed
	 */
	public function all($entryId)
	{

	}

	/**
	 * Get specific field for entry
	 *
	 * @param  integer $entryId
	 * @param  string  $key
	 * @return mixed
	 */
	public function get($entryId, $key)
	{

	}

	/**
	 * Create new field value
	 *
	 * @param integer $entryId
	 * @param string  $key
	 * @param mixed   $value
	 */
	public function add($entryId, $key, $value)
	{
		$field = new Field;
		$field->entry_id = $entryId;
		$field->name     = $key;
		$field->value    = $value;

		return $field->save();
	}

	/**
	 * Update field value
	 *
	 * @param  integer $entryId
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return mixed
	 */
	public function update($entryId, $key, $value)
	{
		$field        = Field::where('entry_id', $entryId)->where('name', $key)->first();
		$field->value = $value;

		return $field->save();
	}

	/**
	 * Add if missing, else update
	 *
	 * @param integer $entryId
	 * @param string  $key
	 * @param mixed]  $value
	 */
	public function addOrUpdate($entryId, $key, $value)
	{
		// And save accordinly
		if ($this->exists($entryId, $field->name))
		{
			$this->update($entryId, $field->name, $value);
		}
		else
		{
			$this->add($entryId, $field->name, $value);
		}
	}

	/**
	 * Check if field exists in DB
	 * @param  integer $entryId
	 * @param  string  $key
	 * @return mixed
	 */
	public function exists($entryId, $key)
	{
		$exists = (bool) Field::where('entry_id', $entryId)->where('name', $key)->count();

		return $exists;
	}

	/**
	 * Save all entry fields
	 *
	 * @param  integer $entryId
	 * @param  mixed   $data
	 * @return mixed
	 */
	public function saveAllForEntry($entryId, $data)
	{
		// Get entry and channel
		$entry   = Entry::with(array('author', 'fields'))->where('id', $entryId)->first();
		$channel = $this->channels->find($entry->channel);

		foreach ($channel->fields as $field)
		{
			if ($field->save != 'direct')
			{
				// Get value from form
				$value = array_get($data, $field->name);

				// Pass through to field save method
				$value = $field->save($value);

				// And save accordinly
				if ($this->exists($entryId, $field->name))
				{
					$this->update($entryId, $field->name, $value);
				}
				else
				{
					$this->add($entryId, $field->name, $value);
				}
			}
		}
	}

}
