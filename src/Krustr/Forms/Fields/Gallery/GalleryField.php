<?php namespace Krustr\Forms\Fields\Gallery;

use Config, File, Input;

class GalleryField extends \Krustr\Forms\Fields\Field {

	/**
	 * Save field value and all collection items
	 * @param  mixed  $data
	 * @return void
	 */
	public function save($data)
	{
		// Find the gallery and create it if needed
		$gallery = $this->galleryRepo->createOrUpdate(array(
			'entry_id' => (int) Input::get('entry_id'),
			'field_id' => $this->name,
		));

		// Paths to uploaded file
		$paths = array_unique(explode(";", trim(Input::get('uploaded-files-' . $this->name), ";")));

		// Save all uploaded items
		if ($paths)
		{
			foreach ($paths as $key => $path)
			{
				if (File::exists($path))
				{
					// Get and create target path
					$target  = $this->mediaPath(pathinfo($path, PATHINFO_BASENAME), true);

					// Get relative path
					$relativePath = str_replace(public_path(), '', $target);

					// Move the file
					File::move($path, $target);

					// Create predefined dimmensions
					$dimensions = Config::get('krustr::media.image_dimensions');
					app('krustr.image')->createDimensions($relativePath, $dimensions);

					// And create database entry
					$this->mediaRepo->create(array(
						'parent_id' => $gallery->id,
						'entry_id'  => (int) Input::get('entry_id'),
						'field_id'  => $this->name,
						'path'      => $relativePath
					));
				}
			}
		}

		return $gallery->id;
	}

	/**
	 * Reformat the value
	 * @return mixed
	 */
	function value()
	{
		$gallery = app('Krustr\Repositories\Interfaces\GalleryRepositoryInterface')->find($this->value);

		return $gallery;
	}

	/**
	 * Renders the field view
	 * @return View
	 */
	public function render($value = null, $additionalData = array())
	{
		$gallery = $this->value;
		$media   = (isset($this->value->media)) ? $this->value->media : null;

		return parent::render($value, array('gallery' => $gallery, 'media' => $media));
	}

}
