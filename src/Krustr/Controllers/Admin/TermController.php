<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Forms\EntryForm;
use Krustr\Repositories\Interfaces\TermRepositoryInterface;
use Krustr\Repositories\Interfaces\TaxonomyRepositoryInterface;
use Krustr\Services\Validation\EntryValidator;

class TermController extends BaseController {

	/**
	 * Term repository
	 * @var EntryRepository
	 */
	protected $termRepository;

	/**
	 * Taxonomy repository
	 * @var TaxonomyRepositoryInterface
	 */
	protected $taxonomyRepository;

	/**
	 * Initialize dependencies
	 * @param TermRepositoryInterface      $termRepository
	 * @param TaxonomyRepositoryInterface  $taxonomyRepository
	 */
	public function __construct(TermRepositoryInterface $termRepository, TaxonomyRepositoryInterface $taxonomyRepository)
	{
		$this->termRepository     = $termRepository;
		$this->taxonomyRepository = $taxonomyRepository;
		$this->taxonomy           = $this->taxonomyRepository->find(Request::segment(3));

		View::share('taxonomy', $this->taxonomy);
	}

	/**
	 * List all terms in taxonomy
	 * @return View
	 */
	public function index()
	{
		$terms = $this->termRepository->all($this->taxonomy->name);

		return View::make('krustr::terms.index', array('terms' => $terms));
	}

	/**
	 * Display form for new term in taxonomy
	 * @return View
	 */
	public function create()
	{
		return View::make('krustr::terms.create');
	}

	/**
	 * Store new term
	 * @return Redirect
	 */
	public function store()
	{

	}

	/**
	 * Display form for editing a term
	 * @return View
	 */
	public function edit($id)
	{
		$term = $this->termRepository->find($id);

		return View::make('krustr::terms.edit', array('term' => $term));
	}

}
