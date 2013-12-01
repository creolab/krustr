<?php namespace Krustr\Repositories;

use Krustr\Models\Term;
use Krustr\Repositories\Interfaces\TaxonomyRepositoryInterface;
use Krustr\Repositories\Collections\TermCollection;
use Krustr\Repositories\Entities\TermEntity;

class TermdDbRepository implements Interfaces\FieldRepositoryInterface {

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
	public function all($taxId)
	{
		return array();
	}

	/**
	 * Get terms for entry in taxonomy
	 * @param  integer $entryId
	 * @param  string  $key
	 * @return mixed
	 */
	public function find($entryId, $key)
	{
		return array();
	}

	/**
	 * Create new field value
	 *
	 * @param integer $entryId
	 * @param string  $key
	 * @param mixed   $value
	 */
	public function create($entryId, $key, $value, $definition = null)
	{

	}

	/**
	 * Update field value
	 *
	 * @param  integer $entryId
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return mixed
	 */
	public function update($entryId, $key, $value, $definition = null)
	{

	}

	/**
	 * Add if missing, else update
	 * @param integer $entryId
	 * @param string  $key
	 * @param mixed   $value
	 */
	public function createOrUpdate($entryId, $key, $value, $definition = null)
	{

	}

	/**
	 * Check if field exists in DB
	 * @param  integer $entryId
	 * @param  string  $key
	 * @return mixed
	 */
	public function exists($entryId, $key)
	{
		return false;
	}

}
