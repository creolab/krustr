<?php namespace Krustr\Services\Install;

use File;

class ThemeInstaller {

	public function fire($symlinks = false)
	{
		// First remove the published theme
		$theme = public_path() . '/themes/default';
		if     (is_link($theme))           File::delete($theme);
		elseif (File::isDirectory($theme)) File::deleteDirectory($theme);

		// Create dir if missing
		$dir = public_path() . '/themes';
		if ( ! File::exists($dir)) File::makeDirectory($dir, 0777, true);

		if ($symlinks)
		{
			exec('ln -s ../../vendor/creolab/krustr/themes/default public/themes/default');
			//$this->info("Linked default theme.");
		}
		else
		{
			$source      = __DIR__ . '/../../../themes/default';
			$destination = $dir . '/default';
			File::copyDirectory($source, $destination);
			//$this->info("Published default theme to [" . $destination . "]");
		}
	}

}
