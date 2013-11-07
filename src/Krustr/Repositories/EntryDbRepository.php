<?php namespace Krustr\Repositories;

use Krustr\Models\Entry;
use Krustr\Repositories\Collections\EntryCollection;
use Krustr\Repositories\Entities\EntryEntity;

class EntryDbRepository implements Interfaces\EntryRepositoryInterface{

	/**
	 * Get all entries
	 *
	 * @return EntryCollection
	 */
	public function all()
	{
		$entries = Entry::with(array('author', 'fields'))->get()->toArray();

		return new EntryCollection($entries);
	}

	/**
	 * Return all entries in specific channel
	 *
	 * @param  string $channel
	 * @return EntryCollection
	 */
	public function allInChannel($channel)
	{
		$entries = Entry::with(array('author', 'fields'))->inChannel($channel)->get()->toArray();

		return new EntryCollection($entries);
	}

	/**
	 * Find entry for home page
	 *
	 * @return EntryEntity
	 */
	public function home()
	{
		$entry = Entry::with(array('author', 'fields'))->where('home', 1)->published()->firstOrFail()->toArray();

		return new EntryEntity($entry);
	}

	/**
	 * Find specific entry by id
	 *
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function find($id)
	{
		$entry = Entry::with(array('author', 'fields'))->where('id', $id)->published()->firstOrFail()->toArray();

		return new EntryEntity($entry);
	}

	/**
	 * Find single entry by slug
	 *
	 * @param  string $slug
	 * @return EntryEntity
	 */
	public function findBySlug($slug, $channel = null)
	{
		if ($channel) $entry = Entry::with(array('author', 'fields'))->where('slug', $slug)->inChannel($channel)->published()->firstOrFail()->toArray();
		else          $entry = Entry::with(array('author', 'fields'))->where('slug', $slug)->published()->firstOrFail()->toArray();

		return new EntryEntity($entry);
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
		$entry = Entry::find($id);
		$entry->title = array_get($data, 'title');
		$entry->body  = array_get($data, 'body');

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
		return Entry::create($data);
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
