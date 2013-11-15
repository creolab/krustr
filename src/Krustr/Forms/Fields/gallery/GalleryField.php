<?php namespace Krustr\Forms\Fields\Gallery;

class GalleryField extends \Krustr\Forms\Fields\Field {

	public function save($data)
	{
		return 1; // @TODO: A gallery ID
	}

	/**
	 * Reformat the value
	 *
	 * @return mixed
	 */
	function value()
	{
		$gallery = app('Krustr\Repositories\Interfaces\GalleryRepositoryInterface')->find($this->value);

		return $gallery;
	}

}
