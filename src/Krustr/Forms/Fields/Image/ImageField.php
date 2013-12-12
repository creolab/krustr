<?php namespace Krustr\Forms\Fields\Image;

use Config, File, Input;

class ImageField extends \Krustr\Forms\Fields\Field {

	/**
	 * Save image data, move and resize the file
	 * @TODO: Some od the logic can be cleaned up
	 * @param  mixed $data
	 * @return string
	 */
	public function save($data)
	{
		// Path to uploaded file
		$path = trim(Input::get('uploaded-files-' . $this->name), ";");

		// If no new photo was uploaded simply return the existing value
		if ( ! $path)
		{
			if ($this->entry) return $this->entry->field($this->name);
		}
		else
		{
			if ($path and File::exists($path))
			{
				// Get and create target path
				$target  = $this->mediaPath(pathinfo($path, PATHINFO_BASENAME), true);

				// Get relative path
				$relativePath = str_replace(public_path(), '', $target);

				// Move the file
				File::move($path, $target);

				// Delete parent folder if tmp
				$tmpPath = pathinfo($path, PATHINFO_DIRNAME);
				$tmpArr  = explode("/", $tmpPath);
				$tmpDir  = array_pop($tmpArr);
				if (strpos($tmpDir, 'tmp_') === 0) File::deleteDirectory($tmpPath);

				// Create predefined dimmensions
				$dimensions = Config::get('krustr::media.image_dimensions');
				app('krustr.image')->createDimensions($relativePath, $dimensions);

				return $relativePath;
			}
		}
	}

}
