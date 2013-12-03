<?php namespace Krustr\Services\Install;

use File;

class AssetsInstaller {

	public function fire($symlinks = false)
	{
		// First remove the assets
		$theme = public_path() . '/packages/creolab/krustr/assets';
		if     (is_link($theme))           File::delete($theme);
		elseif (File::isDirectory($theme)) File::deleteDirectory($theme);

		// Create dir if missing
		$dir = public_path() . '/packages/creolab/krustr';
		if ( ! File::exists($dir)) File::makeDirectory($dir, 0777, true);

		if ($symlinks)
		{
			exec('ln -s ../../../../vendor/creolab/krustr/assets public/packages/creolab/krustr/assets');
			//$this->info("Linked assets.");
		}
		else
		{
			$source      = __DIR__ . '/../../../assets';
			$destination = $dir . '/assets';
			File::copyDirectory($source, $destination);
			//$this->info("Published assets to [" . $destination . "]");
		}
	}

}
