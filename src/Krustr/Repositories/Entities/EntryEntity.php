<?php namespace Krustr\Repositories\Entities;

use Carbon\Carbon;
use Krustr\Repositories\Collections\FieldCollection;
use Krustr\Repositories\Interfaces\EntryRepositoryInterface;

class EntryEntity extends Entity {

	/**
	 * Entry repository
	 * @var EntryRepositoryInterface
	 */
	protected $entryRepository;

	/**
	 * Taxonomy terms for this entry
	 * @var TermCollection
	 */
	protected $taxonomyTerms;

	/**
	 * Initialize the collection
	 * @param array $items
	 */
	public function __construct($data)
	{
		if (isset($data['author']))
		{
			$data['author'] = new UserEntity((array) $data['author']);
			$data['fields'] = new FieldCollection($data['fields']);
		}

		// Resolve entry repository
		$this->entryRepository = app('Krustr\Repositories\Interfaces\EntryRepositoryInterface');

		parent::__construct($data);
	}

	/**
	 * Get an entry field
	 * @param  string $key
	 * @return mixed
	 */
	public function field($key)
	{
		if (is_array($key)) $key = $key[0];

		foreach ($this->fields as $field)
		{
			if ($key == $field->name)
			{
				return $field->value();
			}
		}
	}

	/**
	 * Get an entry field data
	 * @param  string $key
	 * @return mixed
	 */
	public function fieldData($key)
	{
		if (is_array($key)) $key = $key[0];

		foreach ($this->fields as $field)
		{
			if ($key == $field->name)
			{
				return $field->data;
			}
		}
	}

	/**
	 * Return all terms for taxonomy
	 * @param  string $taxonomyId
	 * @return TermCollection
	 */
	public function terms($taxonomyId = null)
	{
		if ( ! $this->taxonomyTerms)
		{
			$this->taxonomyTerms = $this->entryRepository->terms($this->id, $taxonomyId);
		}

		return $this->taxonomyTerms;
	}

	/**
	 * Check if entry has a term
	 * @param  mixed  $termId
	 * @return boolean
	 */
	public function hasTerm($termId)
	{
		$terms = $this->terms();

		foreach ($terms as $term)
		{
			if ($term->id == $termId) return true;
		}

		return false;
	}

	/**
	 * Returns date for entry
	 * @return string
	 */
	public function getDateAttribute()
	{
		if ($this->published_at) return $this->published_at;
		else                     return $this->updated_at;
	}

}
