<?php namespace Krustr\Repositories;

use Config;

/**
 * Config implementation for channel repository
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class ChannelConfigRepository implements Interfaces\ChannelRepositoryInterface {

	/**
	 * Initialize the channel repository
	 *
	 * @param Channel $channel
	 */
	public function __construct()
	{

	}

	/**
	 * Get all channels
	 *
	 * @return array
	 */
	public function all()
	{
		return Config::get('krustr::channels');
	}

	/**
	 * Find channel by ID
	 *
	 * @param  string $id
	 * @return array
	 */
	public function find($id)
	{
		$channel = Config::get('krustr::channels.'.$id);

		if ($channel)
		{
			$channel['slug'] = $id;
			$channel = new Entities\ChannelEntity($channel);
		}

		return $channel;
	}

}
