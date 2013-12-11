<?php namespace Krustr\Services\Theme;

class Bootstrap {

	protected $app;

	protected $theme;

	protected $entries;

	public function __construct($app)
	{
		$this->app     = $app;
		$this->theme   = $app['config']->get('krustr::theme');
		$this->entries = $this->app['Krustr\Repositories\Interfaces\EntryRepositoryInterface'];
		$this->terms   = $this->app['Krustr\Repositories\Interfaces\TermRepositoryInterface'];

		$this->registerActions();
		$this->registerFilters();
		$this->registerRoutes();
	}

	public function init()
	{

	}

	public function registerActions()
	{

	}

	public function registerRoutes()
	{
		if (file_exists($routes = public_path() . '/themes/' . $this->theme . '/routes.php'))
		{
			include $routes;
		}
	}

	public function registerFilters()
	{
		if (file_exists($filters = public_path() . '/themes/' . $this->theme . '/filters.php'))
		{
			include $filters;
		}
	}

	/**
	 * Try to trigger an actions for specific route
	 * @return mixed
	 */
	public function triggerRoute()
	{

	}

}
