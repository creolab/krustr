<?php namespace Krustr\Repositories;

use DB;
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
	 * Find term by ID
	 * @param  integer $id
	 * @return mixed
	 */
	public function find($id)
	{
		$term = Term::find($id);

		if ($term) return new TermEntity($term->toArray());
	}

	/**
	 * Find term by slug
	 * @param  string $slug
	 * @return mixed
	 */
	public function findBySlug($slug)
	{
		$term = Term::where('slug', $slug)->first();

		if ($term) return new TermEntity($term->toArray());
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
	 * @return boolean
	 */
	public function exists($name)
	{
		return false;
	}

	/**
	 * Save all terms for entry
	 * @param  integer $entryId
	 * @param  mixed   $data
	 * @return mixed
	 */
	public function saveAllForEntry($entryId, $data)
	{
		$taxonomies = array_get($data, 'taxonomy-terms');

		if ($taxonomies)
		{
			foreach ($taxonomies as $taxonomy => $terms)
			{
				$taxonomy = $this->taxonomies->find($taxonomy);

				if ($taxonomy)
				{
					// Delete all
					$query = DB::table('entry_term')->where('entry_id', $entryId)->where('taxonomy_id', $taxonomy->name_singular)->delete();

					// And insert new ones
					foreach ($terms as $termId)
					{
						$query = DB::table('entry_term')->insert(array(
							'entry_id'    => $entryId,
							'term_id'     => (int) $termId,
							'taxonomy_id' => $taxonomy->name_singular,
							'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
							'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
						));
					}
				}
			}
		}
	}

}
