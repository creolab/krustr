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
			$media = Media::where('parent_id', $gallery->id)->where('type', 'item')->get();

			if ($media)
			{
				$media = new MediaCollection($media->toArray());
				$gallery->set('media', $media);
			}

			return $gallery;
		}
	}

}
