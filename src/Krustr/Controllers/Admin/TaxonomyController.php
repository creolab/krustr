<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Forms\EntryForm;
use Krustr\Repositories\Interfaces\TermRepositoryInterface;
use Krustr\Repositories\Interfaces\TaxonomyRepositoryInterface;
use Krustr\Services\Validation\EntryValidator;

class TaxonomyController extends BaseController {

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

		View::share('taxonomy', $this->taxonomy);
		View::share('meta_title', 'Content / ' . ucfirst($this->channel->name));
	}

	/**
	 * List all terms in taxonomy
	 * @return View
	 */
	public function index()
	{

	}

}
