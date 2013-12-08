<?php namespace Krustr\Repositories;

use Krustr\Models\Media;
use Krustr\Repositories\Entities\GalleryEntity;
use Krustr\Repositories\Collections\MediaCollection;

class GalleryDbRepository implements Interfaces\GalleryRepositoryInterface {

	/**
	 * Find media item
	 *
	 * @param  integer $id
	 * @return mixed
	 */
	public function find($id)
	{
		// First find gallery item
		$gallery = Media::where('id', $id)->where('type', 'collection')->first();

		if ($gallery)
		{
			$gallery = new GalleryEntity($gallery->toArray());

			// Now get media
			$media = Media::where('parent_id', $gallery->id)->where('type', 'item')->orderBy('order')->get();

			if ($media)
			{
				$media = new MediaCollection($media->toArray());
				$gallery->set('media', $media);
			}

			return $gallery;
		}
	}

	/**
	 * Create new gallery
	 * @param array $data
	 */
	public function create($data)
	{
		$gallery = new Media;
		$gallery->entry_id    = (int) array_get($data, 'entry_id');
		$gallery->field_id    = array_get($data, 'field_id');
		$gallery->title       = array_get($data, 'title');
		$gallery->description = array_get($data, 'description');
		$gallery->type        = 'collection';
		$gallery->save();

		return new GalleryEntity($gallery->toArray());
	}

	/**
	 * Update gallery
	 * @param integer $id
	 * @param array   $data
	 */
	public function update($id, $data)
	{
		$gallery = Media::find($id);
		$gallery->title       = array_get($data, 'title');
		$gallery->description = array_get($data, 'description');
		$gallery->save();

		return new GalleryEntity($gallery->toArray());
	}

	/**
	 * Add if missing, else update
	 * @param array $data
	 */
	public function createOrUpdate($data)
	{
		// Try to get the gallery
		$gallery = Media::where('type',      'collection')
		                ->where('parent_id', null)
		                ->where('entry_id',  array_get($data, 'entry_id'))
		                ->where('field_id',  array_get($data, 'field_id'))
		                ->first();

		// Create or update
		if ($gallery)
		{
			return $this->update($gallery->id, $data);
		}
		else
		{
			return $this->create($data);
		}
	}

}
