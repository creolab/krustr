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

		$this->registerActions();
		$this->registerRoutes();
	}

	public function registerActions()
	{

	}

	public function registerRoutes()
	{
		include public_path() . '/themes/' . $this->theme . '/routes.php';
	}

}
