<?php namespace Krustr\Repositories;

use DB, Input, Str;
use Krustr\Models\Fragment;
use Krustr\Repositories\Collections\FragmentCollection;
use Krustr\Repositories\Entities\FragmentEntity;
use Krustr\Services\Validation\FragmentValidator;

class FragmentDbRepository extends DbRepository implements Interfaces\FragmentRepositoryInterface {

	/**
	 * Initialize dependencies
	 * @param FragmentValidator  $validation
	 */
	public function __construct(FragmentValidator $validation)
	{
		$this->validation = $validation;
	}

	/**
	 * Get all fragments
	 * @return mixed
	 */
	public function all()
	{
		$fragments = Fragment::all();

		return new FragmentCollection($fragments->toArray());
	}

	/**
	 * Find fragment
	 * @param  integer $id
	 * @return mixed
	 */
	public function find($id)
	{
		$fragment = Fragment::find($id);

		if ($fragment) return new FragmentEntity($fragment->toArray());
	}

	/**
	 * Find fragment by slug
	 * @param  string $slug
	 * @return mixed
	 */
	public function findBySlug($slug)
	{
		$fragment = Fragment::where('slug', $slug)->first();

		if ($fragment) return new FragmentEntity($fragment->toArray());
	}

	/**
	 * Create new fragment
	 * @param array $data
	 */
	public function create($data)
	{
		// First validate the input
		if ($this->validation->passes($data))
		{
			$fragment = new Fragment(array(
				'title' => array_get($data, 'title'),
				'slug'  => Str::slug(array_get($data, 'slug')),
				'body'  => array_get($data, 'body'),
			));
			$fragment->save();

			return $fragment->id;
		}

		// Set errors
		$this->errors = $this->validation->errors();

		return false;
	}

	/**
	 * Update fragment
	 * @param integer $id
	 * @param array   $data
	 */
	public function update($id, $data)
	{
		// First validate the input
		if ($this->validation->passes($data))
		{
			// Set the data
			$fragment = Fragment::find($id);
			$fragment->fill(array(
				'title' => array_get($data, 'title'),
				'body'  => array_get($data, 'body'),
			));

			// Slug
			if ($slug = array_get($data, 'slug') and $slug != $fragment->slug) $fragment->slug = Str::slug($slug);

			return $fragment->save();
		}

		// Set errors
		$this->errors = $this->validation->errors();

		return false;
	}

	/**
	 * Add if missing, else update
	 * @param array   $data
	 */
	public function createOrUpdate($data)
	{

	}

	/**
	 * Check if fragment exists in DB
	 * @param  string $slug
	 * @return boolean
	 */
	public function exists($slug)
	{
		return false;
	}

}
