<?php namespace Krustr\Controllers\Api;

use Redirect, Response, Request, View;
use Krustr\Repositories\Interfaces\MediaRepositoryInterface;

class MediaController extends BaseController {

	/**
	 * Media repository
	 * @var MediaRepositoryInterface
	 */
	protected $media;

	/**
	 * Init dependencies
	 * @param MediaRepositoryInterface $media
	 */
	public function __construct(MediaRepositoryInterface $media)
	{
		$this->media = $media;
	}

	/**
	 * Delete media item
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->media->destroy($id))
		{
			return Response::json(array('error' => false, 'ok' => true));
		}
		else
		{
			return Response::json(array('error' => true, 'ok' => false), 400);
		}
	}

}
