<?php namespace Krustr\Controllers\Api;

use Redirect, Response, Request, View;
use Krustr\Repositories\Interfaces\MediaRepositoryInterface;
use Krustr\Repositories\Interfaces\FieldRepositoryInterface;

class MediaController extends BaseController {

	/**
	 * Media repository
	 * @var MediaRepositoryInterface
	 */
	protected $media;

	/**
	 * Field repository
	 * @var FieldRepositoryInterface
	 */
	protected $field;

	/**
	 * Init dependencies
	 * @param MediaRepositoryInterface $media
	 */
	public function __construct(MediaRepositoryInterface $media, FieldRepositoryInterface $field)
	{
		$this->media = $media;
		$this->field = $field;
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

		return Response::json(array('error' => true, 'ok' => false), 400);
	}

	/**
	 * Destroy file in content field
	 * @param  integer $id
	 * @return Resonse
	 */
	public function destroyField($entry, $fieldId)
	{
		$field = $this->field->find($entry, $fieldId);

		if ($field and $this->field->destroy($field->id))
		{
			return Response::json(array('error' => false, 'ok' => true));
		}

		return Response::json(array('error' => true, 'ok' => false), 400);
	}

}
