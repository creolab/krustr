<?php namespace Krustr;

use Illuminate\Support\ServiceProvider;

class KrustrServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('creolab/krustr', 'krustr', __DIR__.'/../');
		$this->bootCommands();

		// Register the package configuration with the loader.
		$this->app['config']->addNamespace('theme', public_path() . '/' .
												  $this->app['config']->get('krustr::theme_dir') . '/' .
												  $this->app['config']->get('krustr::theme') .
												  '/config');

		// Add theme namespaces
		$this->app['view']->addNamespace('krustr_fields', __DIR__ . '/forms/fields');
		$this->app['view']->addNamespace('theme', public_path() . '/' .
												  $this->app['config']->get('krustr::theme_dir') . '/' .
												  $this->app['config']->get('krustr::theme') .
												  '/views');

		// Register content
		$this->registerFieldDefinitions();
		$this->registerBindings();
		$this->registerChannels();
		$this->registerBladeExtensions();
		$this->registerTheme();

		// Include various files
		require __DIR__ . '/../helpers.php';
		require __DIR__ . '/../filters.php';
		require __DIR__ . '/../routes.php';

		// Initialize backend
		$this->registerBackend();

	}

	/**
	 * Register the service provider
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Register all available commands
	 *
	 * @return void
	 */
	public function bootCommands()
	{
		// Add install command to IoC
		// $this->app['krustr.commands.install'] = $this->app->share(function($app) {
		// 	return new Commands\InstallCommand;
		// });

		// Add refresh command to IoC
		// $this->app['krustr.commands.refresh'] = $this->app->share(function($app) {
		// 	return new Commands\RefreshCommand;
		// });

		// Add dev command to IoC
		$this->app['krustr.commands.dev'] = $this->app->share(function($app) {
			return new Commands\DevCommand;
		});

		// Now register all the commands
		$this->commands(/*'krustr.commands.install', 'krustr.commands.refresh',*/ 'krustr.commands.dev');
	}

	public function registerChannels()
	{
		$channelRepository = $this->app->make('Krustr\Repositories\Interfaces\ChannelRepositoryInterface');
		$this->app['krustr.channels'] = new Repositories\Collections\ChannelCollection($channelRepository->all());
	}

	/**
	 * Register all field definitions
	 *
	 * @return void
	 */
	public function registerFieldDefinitions()
	{
		$this->app['krustr.fields'] = new Repositories\Collections\FieldTypeCollection($this->app['config']->get('krustr::fields'));
	}

	/**
	 * Register all bindings
	 *
	 * @return void
	 */
	public function registerBindings()
	{
		// Register repositories
		$this->app->bind('Krustr\Repositories\Interfaces\EntryRepositoryInterface',   'Krustr\Repositories\EntryDbRepository');
		$this->app->bind('Krustr\Repositories\Interfaces\ChannelRepositoryInterface', 'Krustr\Repositories\ChannelConfigRepository');
		$this->app->bind('Krustr\Repositories\Interfaces\FieldRepositoryInterface',   'Krustr\Repositories\FieldDbRepository');
		$this->app->bind('Krustr\Repositories\Interfaces\UserRepositoryInterface',    'Krustr\Repositories\UserDbRepository');

		// Register backend navigation environment
		$this->app->singleton('krustr.navigation', function($app)
		{
			return new \Krustr\Services\Navigation\Navigation($app);
		});

		// Register content publisher
		$this->app->singleton('krustr.publisher', function($app)
		{
			return new \Krustr\Services\Publisher($app['Krustr\Repositories\Interfaces\EntryRepositoryInterface']);
		});
	}

	/**
	 * Register the Blade extensions for the views
	 *
	 * @return void
	 */
	protected function registerBladeExtensions()
	{
		$blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

		// Single asset
		$blade->extend(function($value, $compiler)
		{
			$matcher = $compiler->createMatcher('theme_asset');

			return preg_replace($matcher, '$1<?php echo theme_asset_tag$2; ?>', $value);
		});

		// Asset collection
		$blade->extend(function($value, $compiler)
		{
			$matcher = $compiler->createMatcher('theme_assets');

			return preg_replace($matcher, '$1<?php echo theme_assets$2; ?>', $value);
		});
	}

	/**
	 * Register various backend services
	 *
	 * @return void
	 */
	public function registerBackend()
	{
		// Register backend navigation
		$this->app['krustr.navigation']->add('backend', $this->app['config']->get('krustr::navigation.backend'));
	}

	/**
	 * Register the theme and initialize it
	 *
	 * @return void
	 */
	public function registerTheme()
	{
		// Register theme singleton
		$this->app->singleton('krustr.theme', function($app)
		{
			return new \Theme\Bootstrap($app);
		});

		// Initialize the theme
		$this->app['krustr.theme']->init();
	}

}
