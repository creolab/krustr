<?php namespace Krustr\Controllers\Api;

use Config, Input, Response;
use Krustr\Services\Upload;

class UploadController extends BaseController {

	/**
	 * Upload service dependency
	 *
	 * @var UserRepository
	 */
	protected $upload;

	/**
	 * Initialize the upload controller with dependencies
	 *
	 * @param Krustr\Services\Upload $upload
	 */
	public function __construct(Upload $upload)
	{
		$this->upload = $upload;
	}

	/**
	 * Fire the upload action
	 *
	 * @return Response
	 */
	public function fire()
	{
		$reponse = $this->upload->fire(Input::file('file'), Config::get('krustr::media.tmp_path'), array(
			'tmp_url' => Config::get('krustr::media.tmp_url'),
		));

		return Response::json($reponse);
	}

}
