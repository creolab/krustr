<?php namespace Krustr\Controllers\Admin;

use Input, Request, Response, View;
use Krustr\Repositories\Interfaces\FieldRepositoryInterface;

class ImageController extends BaseController {

	/**
	 * Field repository
	 * @var FieldRepositoryInterface
	 */
	protected $fields;

	/**
	 * Init dependencies
	 * @param FieldRepositoryInterface $fields
	 */
	public function __construct(FieldRepositoryInterface $fields)
	{
		$this->fields = $fields;
	}

	/**
	 * Display image editor
	 * @param  integer $fieldId
	 * @return View
	 */
	public function editFieldImage($fieldId)
	{
		$field = $this->fields->findById($fieldId);

		return View::make('krustr::image.editor')->withField($field);
	}

}
