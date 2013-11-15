<?php namespace Krustr\Repositories;

use Auth, Str;
use Krustr\Models\Entry;
use Krustr\Repositories\Collections\EntryCollection;
use Krustr\Repositories\Entities\EntryEntity;
use Krustr\Repositories\Interfaces\FieldRepositoryInterface;
use Krustr\Services\Validation\EntryValidator;

class EntryDbRepository extends Repository implements Interfaces\EntryRepositoryInterface {

	/**
	 * Repository for saving field data
	 *
	 * @var FieldRepositoryInterface
	 */
	protected $fields;

	/**
	 * Init dependecies
	 */
	public function __construct(EntryValidator $validation, FieldRepositoryInterface $fields)
	{
		$this->validation = $validation;
		$this->fields     = $fields;
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
		if ($status = array_get($options, 'status')) $query->where('status', $status);

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
	public function allInChannel($channel, $options = array())
	{
		$query = Entry::with(array('author', 'fields'))->inChannel($channel)->orderBy('created_at', 'desc');

		// Status
		if ($status = array_get($options, 'status')) $query->where('status', $status);

		// Run query
		$entries = $query->get();

		return new EntryCollection($entries->toArray());
	}

	/**
	 * Return all published entries in channel
	 *
	 * @param  string $channel
	 * @return EntryCollection
	 */
	public function allPublishedInChannel($channel)
	{
		return $this->allInChannel($channel, array('status' => 'published'));
	}

	/**
	 * Find entry for home page
	 *
	 * @return EntryEntity
	 */
	public function home()
	{
		$entry = Entry::with(array('author', 'fields'))->where('home', 1)->published()->first();

		if ($entry) return new EntryEntity($entry->toArray());
	}

	/**
	 * Find specific entry by id
	 *
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function find($id, $options = array())
	{
		$query = Entry::with(array('author', 'fields'))->where('id', $id);

		// Status
		if ($status = array_get($options, 'status')) $query->where('status', $status);

		// Run query
		$entry = $query->first();

		if ($entry) return new EntryEntity($entry->toArray());
	}

	/**
	 * Find published entry
	 *
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function findPublished($id)
	{
		return $this->find($id, array('status' => 'published'));
	}

	/**
	 * Find single entry by slug
	 *
	 * @param  string $slug
	 * @return EntryEntity
	 */
	public function findBySlug($slug, $channel = null, $options = array())
	{
		if ($channel) $query = Entry::with(array('author', 'fields'))->where('slug', $slug)->inChannel($channel);
		else          $query = Entry::with(array('author', 'fields'))->where('slug', $slug);

		// Status
		if ($status = array_get($options, 'status')) $query->published();

		// Run query
		$entry = $query->first();

		if ($entry) return new EntryEntity($entry->toArray());
	}

	/**
	 * Find published entry by slug
	 *
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function findPublishedBySlug($slug, $channel = null)
	{
		return $this->findBySlug($slug, $channel, array('status' => 'published'));
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
			$entry = new Entry(array(
				'author_id' => Auth::user()->id,
				'slug'      => Str::slug(array_get($data, 'title')),
				'title'     => array_get($data, 'title'),
				'body'      => array_get($data, 'body'),
				'channel'   => array_get($data, 'channel'),
				'status'    => $this->inputStatus($data),
			));
			$entry->save();

			// Save custom fields
			$this->fields->saveAllForEntry($entry->id, $data);

			return $entry->id;
		}

		// Set errors
		$this->errors = $this->validation->errors();

		return false;
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
		// First validate the input
		if ($this->validation->passes($data))
		{
			// Set the data
			$entry = Entry::find($id);
			$entry->fill(array(
				'title'   => array_get($data, 'title'),
				'body'    => array_get($data, 'body'),
				'channel' => array_get($data, 'channel'),
				'status'  => $this->inputStatus($data),
			));

			// Save custom fields
			$this->fields->saveAllForEntry($id, $data);

			return $entry->save();
		}

		// Set errors
		$this->errors = $this->validation->errors();

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

	/**
	 * Get status from input for entry
	 *
	 * @return string
	 */
	protected function inputStatus($options)
	{
		$status = 'draft';

		if (isset($options['publish']))
		{
			if     ((int) array_get($options, 'publish') === 1) $status = 'published';
			elseif ((int) array_get($options, 'publish') === 0) $status = 'draft';
		}
		elseif (isset($options['status']))
		{
			$status = $options['status'];
		}

		return $status;
	}

}
