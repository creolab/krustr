<?php namespace Krustr\Services\Theme;

class Bootstrap {

	protected $app;

	public function __construct($app)
	{
		$this->app = $app;

		$this->registerActions();
		$this->registerRoutes();
	}

	public function registerActions()
	{

	}

	public function registerRoutes()
	{
		include public_path() . '/themes/default/routes.php';
	}

}
