<?php namespace Krustr\Repositories;

use File;
use Krustr\Models\Media;
use Krustr\Repositories\Entities\MediaEntity;
use Krustr\Repositories\Collections\MediaCollection;

class MediaDbRepository implements Interfaces\MediaRepositoryInterface {

	/**
	 * Find media item
	 * @param  integer $id
	 * @return mixed
	 */
	public function find($id)
	{
		$media = Media::find($id);

		if ($media) return new MediaEntity($media->toArray());
	}

	/**
	 * Create new media item
	 * @param  array $data
	 * @return mixed
	 */
	public function create($data)
	{
		$media = new Media;
		$media->path      = array_get($data, 'path');
		$media->field_id  = array_get($data, 'field_id');
		$media->entry_id  = (int) array_get($data, 'entry_id');
		$media->parent_id = (int) array_get($data, 'parent_id');
		$media->save();

		return new MediaEntity($media->toArray());
	}

	/**
	 * Update existing media item
	 * @param integer $id
	 * @param array   $data
	 * @return mixed
	 */
	public function update($id, $data)
	{
		echo '<pre>'; print_r(var_dump($id)); echo '</pre>';
		echo '<pre>'; print_r(var_dump($data)); echo '</pre>';
		die();
	}

	/**
	 * Delete media item
	 * @param  integer $id
	 * @return boolean
	 */
	public function destroy($id)
	{
		$media = $this->find($id);

		if ($media)
		{
			// Get absolute path
			$path = public_path(trim($media->path, '/'));

			if (File::exists($path))
			{
				// We also need to find all resized images to clean everything up
				$this->deleteResized($path);
			}

			// Delete from database
			Media::destroy($id);

			return true;
		}
	}

	/**
	 * Find resized media for a path
	 * @param  string $path
	 * @return array
	 */
	public function findResized($path)
	{
		$resized  = array();
		$filename = pathinfo($path, PATHINFO_BASENAME);

		// Find child directories
		$directory = pathinfo($path, PATHINFO_DIRNAME);
		$directories = File::directories($directory);

		if ($directories)
		{
			foreach ($directories as $dir)
			{
				if (File::exists($deleteFile = $dir . '/' . $filename))
				{
					$resized[] = $deleteFile;
				}
			}
		}

		return $resized;
	}

	/**
	 * Delete all resized versions of a media item
	 * @param  string $path
	 * @return boolean
	 */
	public function deleteResized($path)
	{
		$resized = $this->findResized($path);

		return File::delete($resized);
	}

}
