<?php namespace Krustr\Repositories;

use Krustr\Models\Entry;
use Krustr\Models\Field;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;

class FieldDbRepository implements Interfaces\FieldRepositoryInterface {

	protected $entries;
	protected $channels;

	public function __construct(ChannelRepositoryInterface $channels)
	{
		$this->channels = $channels;
	}

	public function all($entryId)
	{

	}

	public function get($entryId, $key)
	{

	}

	public function add($entryId, $key, $value)
	{
		echo '<pre>'; print_r(var_dump("Adding...")); echo '</pre>';
		$field = new Field;
		$field->entry_id = $entryId;
		$field->name     = $key;
		$field->value    = $value;

		return $field->save();
	}

	public function update($entryId, $key, $value)
	{
		echo '<pre>'; print_r(var_dump("Updating...")); echo '</pre>';
		$field        = Field::where('entry_id', $entryId)->where('name', $key)->first();
		$field->value = $value;

		return $field->save();
	}

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

	public function exists($entryId, $key)
	{
		$exists = (bool) Field::where('entry_id', $entryId)->where('name', $key)->count();

		return $exists;
	}

	public function saveForEntry($entryId, $data)
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

				echo '<pre>'; print_r("====================================================================================================="); echo '</pre>';
				echo '<pre>'; print_r("====================================================================================================="); echo '</pre>';
			}
		}


		die();
	}

}
