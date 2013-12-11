<?php namespace Krustr\Controllers\Admin;

use Input, Request, Response, View;
use Krustr\Repositories\Interfaces\FieldRepositoryInterface;

class ImageController extends BaseController {

	protected $fields;

	public function __construct(FieldRepositoryInterface $fields)
	{
		$this->fields = $fields;
	}

	public function editFieldImage($fieldId)
	{
		$field = $this->fields->findById($fieldId);

		return View::make('krustr::image.editor')->withField($field);
	}

}
