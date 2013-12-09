<?php namespace Krustr\Forms\Fields;

use Config, File, View;
use Krustr\Models\Field as FieldModel;

/**
 * Base class for various content fields
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
abstract class Field implements FieldInterface {

	/**
	 * Data container
	 * @var array
	 */
	protected $data;

	/**
	 * Field repo dependency
	 * @var FieldRepositoryInterface
	 */
	protected $repo;

	/**
	 * Media repo dependency
	 * @var MediaRepositoryInterface
	 */
	protected $mediaRepo;

	/**
	 * Gallery repo dependency
	 * @var GalleryRepositoryInterface
	 */
	protected $galleryRepo;

	/**
	 * Field repo dependency
	 * @var FieldRepositoryInterface
	 */
	protected $fieldRepo;

	/**
	 * Initiliaze the field
	 *
	 * @param mixed $data
	 */
	public function __construct(&$field, $value = null)
	{
		// Dependencies
		$this->repo        = \App::make('Krustr\Repositories\Interfaces\FieldRepositoryInterface');
		$this->mediaRepo   = \App::make('Krustr\Repositories\Interfaces\MediaRepositoryInterface');
		$this->galleryRepo = \App::make('Krustr\Repositories\Interfaces\GalleryRepositoryInterface');
		$this->fieldRepo   = \App::make('Krustr\Repositories\Interfaces\FieldRepositoryInterface');

		// Get passed data
		$this->data       = $field->data;

		// Get value and field object
		$this->set('value', $value);
	}

	/**
	 * Renders the field view
	 *
	 * @return View
	 */
	public function render($value = null, $additionalData = array())
	{
		if ($value) $this->value = $value;

		if ($this->view)
		{
			// Prepare data
			$data = array(
				'field' => $this,
				'value' => $this->value,
			);

			// Merge additional if needed
			if ($additionalData) $data = array_merge($additionalData, $data);

			// Build HTML
			$html = View::make($this->view, $data);

			return $html;
		}
	}

	/**
	 * Save the field value
	 *
	 * @return mixed
	 */
	public function save($value = null)
	{
		return $value;
	}

	/**
	 * Return field value
	 *
	 * @return mixed
	 */
	public function value()
	{
		return $this->value;
	}

	/**
	 * Set a field data value
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 * Return media path for field
	 *
	 * @return string
	 */
	public function mediaPath($file = null, $createPath = false)
	{
		$path = Config::get('krustr::media.upload_path');

		// Add entry data
		if ($this->entry)
		{
			$path .= 'entries/' . $this->entry->id . '/';
		}

		// Finally the name of the field
		$path .= $this->name . '/';

		// Now create the path if needed
		if ($createPath and ! File::isDirectory($path)) File::makeDirectory($path, 0777, true);

		// And the target path
		if ($file) $path .= $file;

		return $path;
	}

	/**
	 * Magic helper
	 * @param  mixed $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if (isset($this->$key))                                                     return $this->$key;
		elseif (isset($this->data[$key]))                                           return $this->data[$key];
		elseif (isset($this->data['field_data'][$key]))                             return $this->data['field_data'][$key];
		elseif (method_exists($this, $method = 'get'.camel_case($key).'Attribute')) return call_user_func(array($this, $method));
	}



}
