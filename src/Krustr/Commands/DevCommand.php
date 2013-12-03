<?php namespace Krustr\Commands;

use File;
use Krustr\Services\Install\AssetsInstaller;
use Krustr\Services\Install\ThemeInstaller;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Reinstall Krustr, migrate, seed
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class DevCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'krustr:dev';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Delete data, run migrations, seed development data.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Reset migrations and migrate
		$this->migrate();

		// Seed database
		$this->seed();

		// Remove published config
		// File::deleteDirectory(app_path() . '/config/packages/creolab');

		// Publish or symlink assets
		$this->assets();

		// Publish or symlink default theme
		$this->theme();

		// We're done
		$this->comment('All done.');
	}

	/**
	 * Reset and re-run migrations
	 *
	 * @return void
	 */
	public function migrate()
	{
		// Reset migrations
		$this->comment('Reseting migrations.');
		$this->comment('**************************************************');
		$this->call('migrate:reset');
		$this->comment('Done.');
		$this->comment('**************************************************');

		// Run all migrations
		$this->comment('Migrating.');
		$this->comment('**************************************************');
		$this->call('migrate');
		$this->call('migrate', array('--package' => 'creolab/krustr'));
		$this->call('migrate', array('--package' => 'creolab/cart'));
		$this->call('migrate', array('--package' => 'creolab/shop'));
		$this->comment('Done.');
		$this->comment('**************************************************');
	}

	/**
	 * Symlink or publish assets
	 *
	 * @return void
	 */
	public function assets()
	{
		$this->comment('Setting up assets.');

		$installer = new AssetsInstaller();
		$installer->fire($this->input->getOption('symlinks'));

		$this->comment('Done.');
		$this->comment('**************************************************');
	}

	/**
	 * Symlink or publish theme
	 *
	 * @return void
	 */
	public function theme()
	{
		$this->comment('Setting up default theme.');

		$installer = new ThemeInstaller();
		$installer->fire($this->input->getOption('symlinks'));

		$this->comment('Done.');
		$this->comment('**************************************************');
	}

	/**
	 * Seed some development data
	 *
	 * @return void
	 */
	public function seed()
	{
		$this->comment('Seeding DB.');
		$this->comment('**************************************************');

		// Seed users
		$seeder = new \Krustr\Seeds\UsersTableSeeder;
		$seeder->run();
		$this->info('Users seeded.');

		// Seed content
		$seeder = new \Krustr\Seeds\EntriesTableSeeder;
		$seeder->run();
		$this->info('Content seeded.');

		$this->comment('Done.');
		$this->comment('**************************************************');
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('symlinks', null, InputOption::VALUE_NONE, 'Symlink admin assets and default theme to public directories for easier development.'),
		);
	}

}
