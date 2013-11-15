<?php namespace Krustr\Forms\Fields\Image;

use Input;

class ImageField extends \Krustr\Forms\Fields\Field {

	public function save($data)
	{
		$entryId = Input::get('entry_id');
		$path     = trim(Input::get('uploaded-files-' . $this->name), ";");
		$url      = trim(Input::get('uploaded-urls-' . $this->name), ";");

		// If no new photo was uploaded simply return the existing value
		if ( ! $path)
		{
			if ($this->entry) return $this->entry->field($this->name);
		}
		else
		{
			if ($entryId and $path and $url)
			{
				// Get relative path
				$path = str_replace(public_path(), '', $path);

				return $path;

				// $field = $this->repo->find($entryId, $this->name);

				// Check if media entry exists
				//if ($entry_id and ! $this->media->exists($entry_id, $this->name))
				//{

				//}
				// echo '<pre>'; print_r(var_dump(base_path())); echo '</pre>';
				// echo '<pre>'; print_r(var_dump(public_path())); echo '</pre>';
				// echo '<pre>'; print_r(var_dump($path)); echo '</pre>';
				// echo '<pre>'; print_r(var_dump($url)); echo '</pre>';
				// die();


				// @TODO: Implement!!!
				return $url;
			}
		}
	}

}
