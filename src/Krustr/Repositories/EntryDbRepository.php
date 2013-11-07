<?php namespace Krustr\Repositories;

use Auth, Str;
use Krustr\Models\Entry;
use Krustr\Repositories\Collections\EntryCollection;
use Krustr\Repositories\Entities\EntryEntity;
use Krustr\Services\Validation\EntryValidator;

class EntryDbRepository extends Repository implements Interfaces\EntryRepositoryInterface {

	/**
	 * Init dependecies
	 */
	public function __construct(EntryValidator $validation)
	{
		$this->validation = $validation;
	}

	/**
	 * Get all entries
	 *
	 * @return EntryCollection
	 */
	public function all($status = null)
	{
		$query = Entry::with(array('author', 'fields'))->orderBy('created_at', 'desc');

		// Status
		if ($status) $query->where('status', $status);

		// Run query
		$entries = $query->get();

		return new EntryCollection($entries->toArray());
	}

	/**
	 * Return all entries in specific channel
	 *
	 * @param  string $channel
	 * @return EntryCollection
	 */
	public function allInChannel($channel, $status = null)
	{
		$query = Entry::with(array('author', 'fields'))->inChannel($channel)->orderBy('created_at', 'desc');

		// Status
		if ($status) $query->where('status', $status);

		// Run query
		$entries = $query->get();

		return new EntryCollection($entries->toArray());
	}

	/**
	 * Find entry for home page
	 *
	 * @return EntryEntity
	 */
	public function home()
	{
		$entry = Entry::with(array('author', 'fields'))->where('home', 1)->published()->first();

		return new EntryEntity($entry->toArray());
	}

	/**
	 * Find specific entry by id
	 *
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function find($id)
	{
		$entry = Entry::with(array('author', 'fields'))->where('id', $id)->first();

		return new EntryEntity($entry->toArray());
	}

	/**
	 * Find single entry by slug
	 *
	 * @param  string $slug
	 * @return EntryEntity
	 */
	public function findBySlug($slug, $channel = null)
	{
		if ($channel) $entry = Entry::with(array('author', 'fields'))->where('slug', $slug)->inChannel($channel)->published()->first();
		else          $entry = Entry::with(array('author', 'fields'))->where('slug', $slug)->published()->first();

		return new EntryEntity($entry->toArray());
	}

	/**
	 * Update exiting content entry
	 *
	 * @param  integer $id
	 * @param  array   $data
	 * @return boolean
	 */
	public function update($id, $data = array())
	{
		// Set the data
		$entry = Entry::find($id);
		$entry->title = array_get($data, 'title');
		$entry->body  = array_get($data, 'body');

		// Publish?
		if (isset($data['publish']))
		{
			if     ((int) array_get($data, 'publish') === 1) $entry->status = 'published';
			elseif ((int) array_get($data, 'publish') === 0) $entry->status = 'draft';
		}

		return $entry->save();
	}

	/**
	 * Create new entry
	 *
	 * @param  array $data
	 * @return boolean
	 */
	public function create($data)
	{
		// First validate the input
		if ($this->validation->passes($data))
		{
			$entry = new Entry;
			$entry->author_id = Auth::user()->id;
			$entry->slug      = Str::slug(array_get($data, 'title'));
			$entry->title     = array_get($data, 'title');
			$entry->body      = array_get($data, 'body');
			$entry->channel   = array_get($data, 'channel');
			$entry->save();

			return $entry->id;
		}

		// Set errors
		$this->errors = $this->validation->errors;

		return false;
	}

	/**
	 * Publish an entry
	 *
	 * @param  integer  $id
	 * @return boolean
	 */
	public function publish($id)
	{
		return App::make('krustr.publisher')->publish($id);
	}

	/**
	 * Upublish an entry
	 *
	 * @param  integer  $id
	 * @return boolean
	 */
	public function unpublish($id)
	{
		return App::make('krustr.publisher')->unpublish($id);
	}

}
