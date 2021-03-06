<?php namespace Krustr\Services\Content;

use App, Config, Response, Request, Route, View;

/**
 * Route public requests to content
 * Fetching content and rendering views is handled by the Finder
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

		// We need the taxonomy repo for some content routes
		$taxRepository = app('Krustr\Repositories\Interfaces\TaxonomyRepositoryInterface');

		// Channel routes
		foreach ($this->channels as $channel)
		{
			// Collection in channel
			Route::get($channel->resource, array('as' => 'channel.'.$channel->resource, 'uses' => 'Krustr\Services\Content\Finder@entryCollection'));

			// Taxonomies
			if ($channel->taxonomies)
			{
				$taxonomies = $taxRepository->all($channel->taxonomies);

				if ( ! $taxonomies->isEmpty())
				{
					foreach ($taxonomies as $taxonomy)
					{
						Route::get($channel->resource . '/'.$taxonomy->slug.'/{term}', array('as' => 'channel.'.$channel->resource.'.tax.'.$taxonomy->name_singular,  'uses' => 'Krustr\Services\Content\Finder@entryTaxonomyCollection'));
					}
				}
			}

			// Single entry
			Route::get($channel->resource . '/{id}', array('as' => 'channel.'.$channel->resource.'.entry',  'uses' => 'Krustr\Services\Content\Finder@entry'));
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
			if ($code == 404 or (Request::segment(1) != Config::get('krustr::backend_url') and Request::segment(1) != Config::get('krustr::api_url')))
			{
				return App::make('krustr.router')->error($code, $exception);
			}
			elseif (Request::segment(1) == Config::get('krustr::api_url'))
			{
				return Response::json(array(
					'ok'      => false,
					'error'   => true,
					'message' => $exception->getMessage(),
					'file'    => $exception->getFile(),
					'line'    => $exception->getLine(),
					'code'    => $code
				), $code);
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

