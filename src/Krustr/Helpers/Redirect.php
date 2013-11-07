<?php namespace Krustr\Helpers;

use Config;

class Redirect extends \Illuminate\Support\Facades\Redirect
{
	public static function admin($path, $status = 302, $headers = array(), $secure = false)
	{
		return parent::to(Config::get('krustr::backend_url') . '/' . $path, $status, $headers, $secure);
	}

	public static function adminRoute($route, $parameters = array(), $status = 302, $headers = array())
	{
		return parent::route(Config::get('krustr::backend_url') . '.' . $route, $parameters, $status, $headers);
	}
}
