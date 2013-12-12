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
		// Target path
		$tmpPath = Config::get('krustr::media.tmp_path');
		$tmpUrl  = Config::get('krustr::media.tmp_url');

		// Custom location
		if ($custom = Input::get('custom'))
		{
			$tmpDir   = 'tmp_' . str_replace("-", "_", $custom) . '_' . uniqid() . '/';
			$tmpPath .= $tmpDir;
			$tmpUrl  .= $tmpDir;
		}

		// Run upload actions
		$reponse = $this->upload->fire(Input::file('file'), $tmpPath, array('tmp_url' => $tmpUrl));

		return Response::json($reponse);
	}

}
