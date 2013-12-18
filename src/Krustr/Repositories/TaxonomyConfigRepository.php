<?php namespace Krustr\Repositories;

use Config;
use Krustr\Repositories\Collections\TaxonomyCollection;
use Krustr\Repositories\Entities\TaxonomyEntity;

class TaxonomyConfigRepository extends Repository implements Interfaces\TaxonomyRepositoryInterface {

	/**
	 * Get all taxonomies
	 * @return array
	 */
	public function all($ids = array())
	{
		if ($ids)
		{
			$taxonomies = array();

			foreach (Config::get('krustr::taxonomies') as $key => $taxonomy)
			{
				if (in_array($key, $ids)) $taxonomies[$key] = $taxonomy;
			}

			return new TaxonomyCollection($taxonomies);
		}
		else
		{
			return Config::get('krustr::taxonomies');
		}
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
