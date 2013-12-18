<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Forms\TermForm;
use Krustr\Repositories\Interfaces\TermRepositoryInterface;
use Krustr\Repositories\Interfaces\TaxonomyRepositoryInterface;
use Krustr\Services\Validation\TermValidator;

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
	 * Current taxonomy
	 * @var TaxonomyEntity
	 */
	protected $taxonomy;

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
		// Setup form
		$form = new TermForm(null, array('route' => 'taxonomies.'.$this->taxonomy->name.'.store'));

		return View::make('krustr::terms.create', array('form' => $form));
	}

	/**
	 * Store new term
	 * @return Redirect
	 */
	public function store()
	{
		$data = array_merge(array('taxonomy_id' => $this->taxonomy->name), Input::all());

		if ($id = $this->termRepository->create($data))
		{
			return Redirect::route('backend.taxonomies.'.$this->taxonomy->name.'.edit', $id)->withAlertSuccess("Saved.");
		}

		return Redirect::back()->withInput()->withErrors($this->termRepository->errors());
	}

	/**
	 * Display form for editing a term
	 * @return View
	 */
	public function edit($id)
	{
		// Find term and setup form
		$term = $this->termRepository->find($id);
		$form = new TermForm($term, array('route' => array('taxonomies.'.$this->taxonomy->name.'.update', $term->id)));

		return View::make('krustr::terms.edit', array('term' => $term, 'form' => $form));
	}

	/**
	 * Update taxonomy term
	 * @param  integer $id
	 * @return Redirect
	 */
	public function update($id)
	{
		if ($this->termRepository->update($id, Input::all()))
		{
			return Redirect::back()->withAlertSuccess('Saved.');
		}

		return Redirect::back()->withInput()->withErrors($this->termRepository->errors());
	}

}
