<?php namespace Krustr\Repositories;

use DB, Input, Str;
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
	 * Search all terms
	 * @param  string $taxonomyId
	 * @param  string $query
	 * @return mixed
	 */
	public function searchAll($taxonomyId, $query = null, $options = array())
	{
		$query = Term::where('taxonomy_id', $taxonomyId)->where('title', 'like', "%$query%")->orderBy('title');

		if ($except = explode(",", array_get($options, 'except')))
		{
			foreach ($except as $term)
			{
				$query->where('title', 'not like', $term);
			}
		}

		$terms = $query->get();

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
	public function create($data)
	{
		$term = new Term;
		$term->title       = array_get($data, 'title');
		$term->slug        = Str::slug($term->title);
		$term->taxonomy_id = array_get($data, 'taxonomy_id');
		$term->save();

		return $term->id;
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
					if ($taxonomy->type == 'tags') $this->saveTags($entryId, $taxonomy, $terms);
					else                           $this->saveCategories($entryId, $taxonomy, $terms);
				}
			}
		}
	}

	public function saveCategories($entryId, $taxonomy, $terms)
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

	public function saveTags($entryId, $taxonomy, $terms)
	{
		// Explode terms if needed
		if (is_string($terms)) $terms = explode(",", $terms);

		// Delete all
		$query = DB::table('entry_term')->where('entry_id', $entryId)->where('taxonomy_id', $taxonomy->name_singular)->delete();

		foreach ($terms as $term)
		{
			if ($term)
			{
				// Add to list if doesn't exist
				if ( ! $id = $this->existsByTitle($term, $taxonomy->name))
				{
					$id = $this->create(array(
						'title'       => $term,
						'type'        => 'tags',
						'taxonomy_id' => $taxonomy->name,
					));
				}

				$query = DB::table('entry_term')->insert(array(
					'entry_id'    => $entryId,
					'term_id'     => (int) $id,
					'taxonomy_id' => $taxonomy->name_singular,
					'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
					'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
				));
			}
		}
	}

	public function existsByTitle($title, $taxonomyId = null)
	{
		if ($taxonomyId) $term = Term::where('title', 'like', $title)->first();
		else             $term = Term::where('title', 'like', $title)->where('taxonomy_id', $taxonomyId)->first();

		if ($term) return $term->id;
	}

}
