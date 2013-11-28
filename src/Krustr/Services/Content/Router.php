<?php namespace Krustr\Services\Content;

use App, Config, Request, Route, View;

/**
 * Route public requests to content
 * @author Boris Strahija <boris@creolab.hr>
 */
class Router {

	/**
	 * Channels that need routes
	 * @var mixed
	 */
	protected $channels;

	/**
	 * Initialize the router
	 * @return void
	 */
	public function init()
	{
		// Load content channels
		$this->channels = App::make('krustr.channels');

		// Init routes and errors
		$this->initContent();
		$this->initErrors();
	}

	/**
	 * Initialize entry routes
	 * @return void
	 */
	public function initContent()
	{
		// Home page
		Route::get('/', array('as' => 'site.home', 'uses' => 'Krustr\Services\Content\Finder@home'));

		// Channel routes
		foreach ($this->channels as $channel)
		{
			Route::get($channel->resource,           array('as' => 'channel.'.$channel->resource.'.collection', 'uses' => 'Krustr\Services\Content\Finder@entryCollection'));
			Route::get($channel->resource . '/{id}', array('as' => 'channel.'.$channel->resource.'.entry',      'uses' => 'Krustr\Services\Content\Finder@entry'));
		}

		// Page routes
		Route::get('{slug}', array('as' => 'public.entry', 'uses' => 'Krustr\Services\Content\Finder@entry'));
	}

	/**
	 * Initialize custom error views
	 *
	 * @return View
	 */
	public function initErrors()
	{
		// Custom error handlers
		return App::error(function(\Exception $exception, $code)
		{
			// 404 errors everywhere, other only in frontend
			if ($code == 404 or Request::segment(1) != Config::get('krustr::backend_url'))
			{
				return $this->error($code, $exception);
			}
		});
	}

	/**
	 * Custom error handler
	 *
	 * @param  integer   $code
	 * @param  Exception $exception
	 * @return mixed
	 */
	public function error($code, $exception = null)
	{
		// Share error and code
		View::share('error', $exception);
		View::share('code', $code);

		// Render the view
		if     (View::exists($view = 'theme::' . $code)) return View::make($view);
		elseif (View::exists($view = 'theme::error'))    return View::make($view);
		else                                             return View::make('theme::index');
	}

}

