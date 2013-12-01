<?php namespace Krustr\Repositories;

use Config;

class TaxonomyConfigRepository implements Interfaces\TaxonomyRepositoryInterface {

	/**
	 * Get all taxonomies
	 * @return array
	 */
	public function all()
	{
		return Config::get('krustr::taxonomies');
	}

	/**
	 * Find taxonomy by ID
	 * @param  string $id
	 * @return array
	 */
	public function find($id)
	{
		$taxonomy = Config::get('krustr::taxonomies.'.$id);

		if ($taxonomy)
		{
			$taxonomy['slug'] = $id;
			$taxonomy = new Entities\TaxonomyEntity($taxonomy);
		}

		return $taxonomy;
	}

}
