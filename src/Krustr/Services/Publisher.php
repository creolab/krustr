<?php namespace Krustr\Services;

use Krustr\Repositories\Interfaces\EntryRepositoryInterface;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;

class Publisher {

	/**
	 * Data repository
	 *
	 * @var EntryRepository
	 */
	protected $repository;

	/**
	 * Initialize the publisher
	 *
	 * @param EntryRepositoryInterface  $repository
	 */
	public function __construct(EntryRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Publish specific content entry
	 *
	 * @param  integer $id
	 * @return boolean
	 */
	public function publish($id)
	{

	}

	/**
	 * Publish all content entries
	 *
	 * @return boolean
	 */
	public function publishAll()
	{

	}

	/**
	 * Unpublish specific content entry
	 *
	 * @param  integer $id
	 * @return boolean
	 */
	public function unpublish($id)
	{

	}

	/**
	 * Unpublish all content entries
	 *
	 * @param  integer $id
	 * @return boolean
	 */
	public function unpublishAll()
	{

	}

}
