<?php namespace Krustr\Repositories;

use Auth, Config, DB, Log, Request, Str;
use Krustr\Models\Entry;
use Krustr\Models\Term;
use Krustr\Repositories\Collections\TermCollection;
use Krustr\Repositories\Interfaces\FieldRepositoryInterface;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;
use Krustr\Repositories\Interfaces\TermRepositoryInterface;
use Krustr\Services\Validation\EntryValidator;
use Illuminate\Database\Eloquent\Builder;

class EntryDbRepository extends DbRepository implements Interfaces\EntryRepositoryInterface {

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
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'Krustr\Repositories\Collections\EntryCollection';

	/**
	 * Entity for single item
	 * @var string
	 */
	protected $entityClass = 'Krustr\Repositories\Entities\EntryEntity';

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
		$this->collection = $this->paginate();

		return $this->collection;
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
			$this->query = Entry::with(array('author', 'fields'))->inChannel($this->channel->name);

			// Options
			$this->query = $this->options($options);

			// Run query
			$this->collection = $this->paginate();

			return $this->collection;
		}
	}

	/**
	 * Return all published entries in channel
	 * @param  string $channel
	 * @return EntryCollection
	 */
	public function allPublishedInChannel($channel, $options = array())
	{
		$options = array_merge(array('status' => 'published'), $options);

		return $this->allInChannel($channel, $options);
	}

	/**
	 * Get all published entries by term ID
	 * @param  string $term
	 * @return EntryCollection
	 */
	public function allPublishedByTerm($termId, $channel = null, $options = array(), $exclude = array())
	{
		if ( ! is_array($termId)) $termId = array($termId);

		// Get channel config
		if ($channel) $this->channel = $this->channels->find($channel);

		// Start the query
		$this->query = Entry::with(array('author', 'fields'))->select('entries.*')->distinct();

		// Exclude some entries
		// if ($exclude) $this->query->whereNotIn('entries.id', $exclude);

		// Order
		$orderBy = array_get($options, 'order_by', 'created_at');
		$order   = array_get($options, 'order',    'desc');

		// Run order
		if ($orderBy == 'rand') $this->query->orderBy(DB::raw('RAND()'), $order);
		else                    $this->query->orderBy($orderBy, $order);

		// Filter by term
		$this->query->join('entry_term', 'entry_term.entry_id', '=', 'entries.id')->whereIn('entry_term.term_id', $termId);

		// Add options
		$this->query = $this->options($options);

		// Run query
		$perPage          = array_get($options, 'limit', null);
		$items            = $this->paginate($perPage);
		$this->collection = new EntryCollection(array_get($items, 'data'));

		return $this->collection;
	}

	/**
	 * Find entry for home page
	 * @return EntryEntity
	 */
	public function home()
	{
		$this->query = Entry::with(array('author', 'fields'))->where('home', 1)->published();

		return $this->item();
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
		return $this->item();
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
		return $this->item();
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
		// Start query
		$this->query = Entry::with(array('author', 'fields'))->where('slug', $slug);

		// Channel
		if ($channel)
		{
			// Get channel config
			$this->channel = $this->channels->find($channel);

			$this->query->inChannel($this->channel->name);
		}

		// Status
		$this->query = $this->options($options);

		// Run query
		return $this->item();
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

			// Template
			if ($template = array_get($data, 'template')) $entry->template = str_replace("-", "_", Str::slug($template));

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

			// Slug
			if ($slug = array_get($data, 'slug') and $slug != $entry->slug) $entry->slug = Str::slug($slug);

			// Template
			$entry->template = str_replace("-", "_", Str::slug(array_get($data, 'template')));

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

	/**
	 * Override the default pagination limit
	 * @param  integer $limit
	 * @return integer
	 */
	public function limit($limit = null)
	{
		if ( ! $limit)
		{
			if (Request::segment(1) == Config::get('krustr::backend_url') and $this->channel and $this->channel->per_page_admin)
			{
				$limit = $this->channel->per_page_admin ?: $this->defaultLimit;
			}
			elseif ($this->channel and isset($this->channel->per_page))
			{
				$limit = $this->channel ? $this->channel->per_page : $this->defaultLimit;
			}
			else
			{
				$limit = $this->defaultLimit;
			}
		}

		return $limit;
	}

}
