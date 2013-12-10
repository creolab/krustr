<?php namespace Krustr\Controllers\Api;

use Input, Redirect, Response, Request, View;
use Krustr\Repositories\Interfaces\TermRepositoryInterface;

class TermController extends BaseController {

	/**
	 * Terms repo
	 * @var TermRepositoryInterface
	 */
	protected $terms;

	/**
	 * Initialize dependecies
	 */
	public function __construct(TermRepositoryInterface $terms)
	{
		$this->terms = $terms;
	}

	/**
	 * List terms
	 * @return Response
	 */
	public function index()
	{
		// Get taxonomy from request
		$taxonomyId = Input::get('taxonomy_id', Request::segment(3));

		// Fetch the terms
		$terms = $this->terms->searchAll($taxonomyId, Input::get('q'), array('except' => Input::get('except')));

		return Response::json($terms);
	}

	/**
	 * Show a specific term
	 * @param  integer $id
	 * @return Response
	 */
	public function show($id)
	{
		// Prepare
		$terms = array();
		$ids   = explode(",", $id);

		foreach ($ids as $id)
		{
			if ($term = $this->terms->find($id))
			{
				$terms[] = $term->toArray();
			}
		}

		if ($term) return Response::json($terms);
	}

}
