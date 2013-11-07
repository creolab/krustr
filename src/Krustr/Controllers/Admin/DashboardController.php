<?php namespace Krustr\Controllers\Admin;

use View;

class DashboardController extends BaseController {

	public function index()
	{
		View::share('meta_title', 'Dashboard');

		return View::make('krustr::dashboard.index');
	}

}
