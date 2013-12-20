<?php namespace Krustr\Controllers\Admin;

use Cache, Redirect, View;

class SystemController extends BaseController {

	/**
	 * Clear all cache
	 * @return View
	 */
	public function clearCache()
	{
		Cache::flush();

		return View::make('krustr::system.cache');
	}

	public function users()
	{
		return Redirect::route('backend.system.users.index');
	}

}
