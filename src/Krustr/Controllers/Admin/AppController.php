<?php namespace Krustr\Controllers\Admin;

/**
 * Base controller for admin interface
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */

class AppController extends BaseController {

	/**
	 * Simply display index view
	 *
	 * @return View
	 */
	public function index()
	{
		return \View::make('krustr::app');
	}

}
