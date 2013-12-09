<?php namespace Krustr\Controllers;

use App, View;
use Illuminate\Routing\Controller;

class FeedController extends Controller {

	/**
	 * RSS feed
	 * @return View
	 */
	public function feed($type = 'rss')
	{
		if ( ! in_array($type, array('rss', 'atom'))) return App::abort(404);

		return View::make('krustr::feed.' . $type);
	}

}
