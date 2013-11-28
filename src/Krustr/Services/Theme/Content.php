<?php namespace Krustr\Services\Theme;

use Config, Data, View;
use Krustr\Models\Entry;

class Content extends \Illuminate\Routing\Controller {

	/**
	 * Simply display a view by the slug
	 * @param  string $slug
	 * @return View
	 */
	public function getView($slug = null)
	{
		if ( ! $slug) $slug = \Request::segment(1);

		return $this->view('theme::' . $slug, array('slug'  => $slug));
	}

	/**
	 * Return view object with passed data
	 * @param  string $view
	 * @param  array  $data
	 * @return View
	 */
	protected function view($view, $data = null)
	{
		// Additional view data
		if ($data and is_array($data))
		{
			View::share($data);
			View::share('channel', null);
		}

		// Template
		View::share('template', $view);
		View::share('template_class', 'tpl-' . str_replace(",", "", $view));

		// Check if view exists
		if ( ! View::exists($view)) return \App::abort(404, 'View not found');

		return View::make($view);
	}

}
