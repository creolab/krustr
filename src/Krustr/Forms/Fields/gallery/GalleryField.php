<?php namespace Krustr\Forms\Fields\Gallery;

class GalleryField extends \Krustr\Forms\Fields\Field {

	/**
	 * Save field value and all collection items
	 * @param  mixed  $data
	 * @return void
	 */
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

	/**
	 * Renders the field view
	 *
	 * @return View
	 */
	public function render($value = null, $additionalData = array())
	{
		return parent::render($value, array('gallery' => $this->value, 'media' => $this->value->media));
	}

}
