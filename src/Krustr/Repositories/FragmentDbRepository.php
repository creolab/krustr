<?php namespace Krustr\Repositories;

use DB, Input, Str;
use Krustr\Models\Fragment;
use Krustr\Repositories\Collections\FragmentCollection;
use Krustr\Repositories\Entities\FragmentEntity;

class FragmentDbRepository implements Interfaces\FragmentRepositoryInterface {

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
	 */
	public function create($data)
	{

	}

	/**
	 * Update fragment
	 */
	public function update($id, $data)
	{

	}

	/**
	 * Add if missing, else update
	 */
	public function createOrUpdate($data)
	{

	}

	/**
	 * Check if fragment exists in DB
	 * @return boolean
	 */
	public function exists($slug)
	{
		return false;
	}

}
