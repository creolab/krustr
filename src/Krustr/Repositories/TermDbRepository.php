<?php namespace Krustr\Repositories;

use Krustr\Models\Term;
use Krustr\Repositories\Interfaces\TaxonomyRepositoryInterface;
use Krustr\Repositories\Collections\TermCollection;
use Krustr\Repositories\Entities\TermEntity;

class TermDbRepository implements Interfaces\TermRepositoryInterface {

	/**
	 * Taxonomies repo
	 * @var TaxonomyRepositoryInterface
	 */
	protected $taxonomies;

	/**
	 * Init dependencies
	 * @param TaxonomyRepositoryInterface $channels
	 */
	public function __construct(TaxonomyRepositoryInterface $taxonomies)
	{
		$this->taxonomies = $taxonomies;
	}

	/**
	 * Get all terms for taxnomy
	 * @param  integer $entryId
	 * @return mixed
	 */
	public function all($taxonomyId)
	{
		$terms = Term::where('taxonomy_id', $taxonomyId)->orderBy('title')->get();

		return new TermCollection($terms->toArray());
	}

	/**
	 * Get terms for entry in taxonomy
	 * @param  integer $entryId
	 * @param  string  $key
	 * @return mixed
	 */
	public function find($slug)
	{
		return array();
	}

	/**
	 * Create new field value
	 */
	public function create()
	{

	}

	/**
	 * Update field value
	 */
	public function update($id)
	{

	}

	/**
	 * Add if missing, else update
	 */
	public function createOrUpdate()
	{

	}

	/**
	 * Check if field exists in DB
	 */
	public function exists($name)
	{
		return false;
	}

}
