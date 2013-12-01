<?php namespace Krustr\Services;

use Log;

/**
 * Simple profiler for Krustr
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class Profiler {

	protected static $marks;

	public static function start($name)
	{
		if (app('config')->get('krustr::debug')) static::$marks[$name] = microtime();
	}

	public static function end($name, $message = null)
	{
		if (app('config')->get('krustr::debug'))
		{
			$duration = round(static::duration($name) * 1000, 2);

			Log::debug("[PROFILER] [$name]: $duration ms [$message]");
		}
	}

	public static function duration($name)
	{
		if (isset(static::$marks[$name]))
		{
			// Get start and end
			list($sm, $ss) = explode(' ', static::$marks[$name]);
			list($em, $es) = explode(' ', microtime());

			// Calculate duration
			$duration = number_format(($em + $es) - ($sm + $ss), 4);

			return $duration;
		}

		// Calculate duration
		$duration = number_format(($em + $es) - ($sm + $ss), 4);
	}

}
