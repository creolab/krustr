<?php namespace Krustr\Repositories;

use Auth, Config, Log, Request, Str;
use Krustr\Models\Entry;
use Krustr\Models\Term;
use Krustr\Repositories\Collections\EntryCollection;
use Krustr\Repositories\Entities\EntryEntity;
use Krustr\Repositories\Collections\TermCollection;
use Krustr\Repositories\Interfaces\FieldRepositoryInterface;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;
use Krustr\Repositories\Interfaces\TermRepositoryInterface;
use Krustr\Services\Validation\EntryValidator;
use Illuminate\Database\Eloquent\Builder;

class EntryDbRepository extends Repository implements Interfaces\EntryRepositoryInterface {

	/**
	 * Repository for saving field data
	 * @var FieldRepositoryInterface
	 */
	protected $fields;

	/**
	 * Repository for saving taxonomy term data
	 * @var TermRepositoryInterface
	 */
	protected $terms;

	/**
	 * Repository for fetching channel data
	 * @var ChannelRepositoryInterface
	 */
	protected $channels;

	/**
	 * Current query channel
	 * @var ChannelEntity
	 */
	protected $channel;

	/**
	 * The current collection of entries
	 * @var EntryCollection
	 */
	protected $collection;

	/**
	 * Collections of entries returned to the View
	 * @var EntryCollection
	 */
	protected $entries;

	/**
	 * Eloquent query builder
	 * @var Builder
	 */
	protected $query;

	/**
	 * Initialize dependencies
	 * @param EntryValidator           $validation
	 * @param FieldRepositoryInterface $fields
	 * @param TermRepositoryInterface  $terms
	 */
	public function __construct(EntryValidator $validation, FieldRepositoryInterface $fields, TermRepositoryInterface $terms)
	{
		$this->validation = $validation;
		$this->fields     = $fields;
		$this->terms      = $terms;
		$this->channels   = app('Krustr\Repositories\Interfaces\ChannelRepositoryInterface');
	}

	/**
	 * Get all entries
	 * @return EntryCollection
	 */
	public function all($options = array())
	{
		// Start the query
		$this->query = Entry::with(array('author', 'fields'))->orderBy('created_at', 'desc');

		// Add options
		$this->query = $this->options($options);

		// Run query
		$items            = $this->paginate();
		$this->entries    = new EntryCollection(array_get($items, 'data'));

		return $this->entries;
	}

	/**
	 * Return all entries in specific channel
	 * @param  string $channel
	 * @return EntryCollection
	 */
	public function allInChannel($channel, $options = array())
	{
		// Get channel config
		$this->channel = $this->channels->find($channel);

		if ($this->channel)
		{
			// Start the query
			$this->query = Entry::with(array('author', 'fields'))->inChannel($this->channel->name)->orderBy('created_at', 'desc');

			// Add options
			$this->query = $this->options($options);

			// Run query
			$items            = $this->paginate();
			$this->entries    = new EntryCollection(array_get($items, 'data'));

			return $this->entries;
		}
	}

	/**
	 * Return all published entries in channel
	 * @param  string $channel
	 * @return EntryCollection
	 */
	public function allPublishedInChannel($channel)
	{
		return $this->allInChannel($channel, array('status' => 'published'));
	}

	/**
	 * Get all published entries by term ID
	 * @param  string $term
	 * @return EntryCollection
	 */
	public function allPublishedByTerm($termId, $channel = null, $options = array())
	{
		// Get channel config
		if ($channel) $this->channel = $this->channels->find($channel);

		// Start the query
		$this->query = Entry::with(array('author', 'fields'))->select('entries.*')->orderBy('created_at', 'desc');

		// Filter by term
		$this->query->join('entry_term', 'entry_term.entry_id', '=', 'entries.id')->where('entry_term.term_id', $termId);

		// Add options
		$this->query = $this->options($options);

		// Run query
		$items            = $this->paginate();
		$this->entries    = new EntryCollection(array_get($items, 'data'));

		return $this->entries;
	}

	/**
	 * Find entry for home page
	 * @return EntryEntity
	 */
	public function home()
	{
		$entry = Entry::with(array('author', 'fields'))->where('home', 1)->published()->first();

		if ($entry) return new EntryEntity($entry->toArray());
	}

	/**
	 * Find specific entry by id
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function find($id, $options = array())
	{
		// Start query
		$this->query = Entry::with(array('author', 'fields'))->where('id', $id);

		// Options
		$this->options($options);

		// Run query
		$entry = $this->query->first();

		if ($entry) return new EntryEntity($entry->toArray());
	}

	/**
	 * Find entry in channel
	 * @param  integer $id
	 * @param  string  $channel
	 * @param  array   $options
	 * @return EntryEntity
	 */
	public function findInChannel($id, $channel, $options = array())
	{
		// Get channel config
		$this->channel = $this->channels->find($channel);

		// Start query
		$this->query = Entry::with(array('author', 'fields'))->inChannel($this->channel->name)->where('id', $id);

		// Options
		$this->options($options);

		// Run query
		$entry = $this->query->first();

		if ($entry) return new EntryEntity($entry->toArray());
	}

	/**
	 * Find published entry
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function findPublished($id, $channel = null)
	{
		if ($channel) return $this->find($id, array('status' => 'published'));
		else          return $this->findInChannel($id, $channel, array('status' => 'published'));
	}

	/**
	 * Find single entry by slug
	 * @param  string $slug
	 * @return EntryEntity
	 */
	public function findBySlug($slug, $channel = null, $options = array())
	{
		if ($channel)
		{
			// Get channel config
			$this->channel = $this->channels->find($channel);

			// Start query
			$this->query = Entry::with(array('author', 'fields'))->where('slug', $slug)->inChannel($this->channel->name);
		}
		else
		{
			$this->query = Entry::with(array('author', 'fields'))->where('slug', $slug);
		}

		// Status
		$this->query = $this->options($options);

		// Run query
		$entry = $this->query->first();

		if ($entry) return new EntryEntity($entry->toArray());
	}

	/**
	 * Find published entry by slug
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function findPublishedBySlug($slug, $channel = null)
	{
		return $this->findBySlug($slug, $channel, array('status' => 'published'));
	}

	/**
	 * Create new entry
	 * @param  array $data
	 * @return boolean
	 */
	public function create($data)
	{
		// First validate the input
		if ($this->validation->passes($data))
		{
			$entry = new Entry(array(
				'author_id'        => Auth::user()->id,
				'slug'             => Str::slug(array_get($data, 'title')),
				'title'            => array_get($data, 'title'),
				'body'             => array_get($data, 'body'),
				'channel'          => array_get($data, 'channel'),
				'status'           => $this->inputStatus($data),
				'meta_title'       => array_get($data, 'meta_title'),
				'meta_keywords'    => array_get($data, 'meta_keywords'),
				'meta_description' => array_get($data, 'meta_description'),
			));
			$entry->save();

			// Save custom fields
			$this->fields->saveAllForEntry($entry->id, $data);

			// Also save taxonomies
			$this->terms->saveAllForEntry($entry->id, $data);

			return $entry->id;
		}

		// Set errors
		$this->errors = $this->validation->errors();

		return false;
	}

	/**
	 * Update exiting content entry
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
				'title'            => array_get($data, 'title'),
				'body'             => array_get($data, 'body'),
				'channel'          => array_get($data, 'channel'),
				'status'           => $this->inputStatus($data),
				'meta_title'       => array_get($data, 'meta_title'),
				'meta_keywords'    => array_get($data, 'meta_keywords'),
				'meta_description' => array_get($data, 'meta_description'),
			));

			// Save custom fields
			$this->fields->saveAllForEntry($id, $data);

			// Also save taxonomies
			$this->terms->saveAllForEntry($id, $data);

			// Log it
			Log::debug('[KRUSTR] [ENTRYREPOSITORY] Entry ['.$id.'] was updated.');

			return $entry->save();
		}

		// Set errors
		$this->errors = $this->validation->errors();

		return false;
	}

	/**
	 * Publish an entry
	 * @param  integer  $id
	 * @return boolean
	 */
	public function publish($id)
	{
		return App::make('krustr.publisher')->publish($id);
	}

	/**
	 * Upublish an entry
	 * @param  integer  $id
	 * @return boolean
	 */
	public function unpublish($id)
	{
		return App::make('krustr.publisher')->unpublish($id);
	}

	/**
	 * Get status from input for entry
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

	/**
	 * Set query options and params
	 * @param  array  $options
	 * @return Builder
	 */
	public function options($options = array())
	{
		if (is_array($options))
		{
			foreach ($options as $key => $value)
			{
				if (is_array($value))
				{
					$this->query->where($key, $value[0], $value[1]);
				}
				else
				{
					$this->query->where($key, $value);
				}
			}
		}

		return $this->query;
	}

	/**
	 * Paginate query results
	 * @param  Builder $query
	 * @param  integer $perPage
	 * @return array
	 */
	public function paginate($perPage = null)
	{
		if ( ! $perPage)
		{
			if (Request::segment(1) == Config::get('krustr::backend_url'))
			{
				$perPage = $this->channel->per_page_admin ?: 10;
			}
			else
			{
				$perPage = $this->channel ? $this->channel->per_page : 10;
			}
		}

		$perPage          = (int) ($perPage ?: 20);
		$this->collection = $this->query->paginate($perPage);
		$items            = $this->collection->toArray();

		return $items;
	}

	/**
	 * Return entry pagination
	 * @return Paginator
	 */
	public function pagination()
	{
		return $this->collection;
	}

	/**
	 * Return current query channel
	 * @return ChannelEntity
	 */
	public function channel()
	{
		return $this->channel;
	}

	/**
	 * Get entry terms
	 * @return TermCollection
	 */
	public function terms($entryId, $taxonomyId = null)
	{
		$query = Term::join('entry_term', 'entry_term.term_id', '=', 'terms.id')
		             ->where('entry_term.entry_id', $entryId);

		// Add taxonomy
		if ($taxonomyId) $query->where('entry_term.taxonomy_id', $taxonomyId);

		// Get terms
		$terms = $query->get();

		return new TermCollection($terms->toArray());
	}

}
