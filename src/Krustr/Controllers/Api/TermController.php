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
		$taxonomy = Input::get('taxonomy_id', 'categories');

		// Fetch the terms
		$terms = $this->terms->all($taxonomy);

		return Response::json($terms);
	}

}
