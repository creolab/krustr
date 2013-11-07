<?php namespace Krustr\Helpers;

class Route extends \Illuminate\Support\Facades\Route {

	/**
	 * Current admin channel
	 * @var ChannelEntity
	 */
	protected static $adminChannel;

	/**
	 * Resolve current admin channel by route
	 * @return Repositories\ChannelEntity
	 */
	public static function adminChannel()
	{
		if ( ! $current = static::$adminChannel)
		{
			$channels = \App::make('krustr.channels');
			$slug     = \Input::get('channel', \Request::segment(3));
			$current  = $channels->find($slug);
		}

		return $current;
	}

	/**
	 * Current admin channel name
	 * @return string
	 */
	public static function adminChannelName()
	{
		$channel = static::adminChannel();

		return $channel->name;
	}

}
