<?php namespace Krustr\Repositories\Collections;

class TaxonomyCollection extends Collection {

	protected $entity = 'Krustr\Repositories\Entities\TaxonomyEntity';

	/**
	 * Find taxonomy by slug
	 * @param  string $slug
	 * @return mixed
	 */
	public function findBySlug($slug)
	{
		foreach ($this->items as &$item)
		{
			if ($item->slug == $slug or $item->name == $slug) return $item;
		}
	}

}
