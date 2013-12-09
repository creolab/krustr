<?php namespace Krustr\Repositories;

use File;
use Krustr\Models\Entry;
use Krustr\Models\Field;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;
use Krustr\Repositories\Collections\FieldCollection;
use Krustr\Repositories\Entities\FieldEntity;

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
	 * @param  integer $entryId
	 * @return mixed
	 */
	public function all($entryId)
	{
		$fields = Field::where('entry_id', $entryId)->get();

		return new FieldCollection($fields);
	}

	/**
	 * Get specific field for entry
	 * @param  integer $entryId
	 * @param  string  $key
	 * @return FieldEntity
	 */
	public function find($entryId, $key)
	{
		$field = Field::where('entry_id', $entryId)->where('name', $key)->first();

		if ($field) return new FieldEntity($field->toArray());
	}

	/**
	 * Get specific field by id
	 * @param  integer $id
	 * @return FieldEntity
	 */
	public function findById($id)
	{
		$field = Field::find($id);

		if ($field) return new FieldEntity($field->toArray());
	}

	/**
	 * Create new field value
	 * @param integer $entryId
	 * @param string  $key
	 * @param mixed   $value
	 */
	public function create($entryId, $key, $value, $definition = null)
	{
		$field = new Field;
		$field->entry_id = $entryId;
		$field->name     = $key;
		$field->value    = $value;
		$field->type     = $definition ? $definition->type : null;

		return $field->save();
	}

	/**
	 * Update field value
	 * @param  integer $entryId
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return mixed
	 */
	public function update($entryId, $key, $value, $definition = null)
	{
		$field        = Field::where('entry_id', $entryId)->where('name', $key)->first();
		$field->value = $value;
		$field->type  = $definition ? $definition->type : null;

		return $field->save();
	}

	/**
	 * Add if missing, else update
	 * @param integer $entryId
	 * @param string  $key
	 * @param mixed   $value
	 */
	public function createOrUpdate($entryId, $key, $value, $definition = null)
	{
		// And save accordinly
		if ($this->exists($entryId, $key))
		{
			$this->update($entryId, $key, $value, $definition);
		}
		else
		{
			$this->create($entryId, $key, $value, $definition);
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
	 * @param  integer $entryId
	 * @param  mixed   $data
	 * @return mixed
	 */
	public function saveAllForEntry($entryId, $data)
	{
		// Get entry and channel
		$entry   = Entry::with(array('author', 'fields'))->where('id', $entryId)->first();
		$entry   = new Entities\EntryEntity($entry->toArray());
		$channel = $this->channels->find($entry->channel);

		foreach ($channel->fields as $field)
		{
			if ($field->save != 'direct')
			{
				// Get value from form
				$value = array_get($data, $field->name);

				// Set field entry
				$field->set('entry', $entry);

				// Pass through to field save method
				$value = $field->save($value);

				// And save accordinly
				$this->createOrUpdate($entryId, $field->name, $value, $field);
			}
		}
	}

	/**
	 * Delete field content from database
	 * @param  integer $id
	 * @return boolean
	 */
	public function destroy($id)
	{
		$field = $this->findById($id);

		if ($field)
		{
			// Delete from database
			Field::destroy($id);

			// And delete file
			if (File::exists($path = public_path($field->value)))
			{
				File::delete($path);
			}

			return true;
		}
	}

}
