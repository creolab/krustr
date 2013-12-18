<?php namespace Krustr\Repositories;

use Validator;

abstract class DbRepository extends Repository {

	/**
	 * Validation errors
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $errors;

	/**
	 * Validation errors
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $validation;

	/**
	 * The current collection of items
	 * @var Collection
	 */
	protected $collection;

	/**
	 * Eloquent query builder
	 * @var Builder
	 */
	protected $query;

	/**
	 * Default limit for pagination
	 * @var integer
	 */
	protected $defaultLimit = 10;

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'Krustr\Repositories\Collections\Collection';

	/**
	 * Entity for single item
	 * @var string
	 */
	protected $entityClass = 'Krustr\Repositories\Entities\Entity';

	/**
	 * Paginate query results
	 * @param  Builder $query
	 * @param  integer $perPage
	 * @return array
	 */
	public function paginate($perPage = null)
	{
		$collectionClass  = $this->collectionClass;
		$perPage          = $this->limit();
		$this->paginated  = $this->query->paginate($perPage);
		$pagination       = $this->paginated->toArray();
		$this->collection = new $collectionClass(array_get($pagination, 'data'));

		return $this->collection;
	}

	/**
	 * Return entry pagination
	 * @return Paginator
	 */
	public function pagination()
	{
		return $this->paginated;
	}

	/**
	 * Simply return limit for pagination
	 * @return integer
	 */
	public function limit($limit = null)
	{
		if ( ! $limit) $limit = $this->defaultLimit;

		return (int) $limit;
	}

	/**
	 * Set query options and params
	 * @param  array  $options
	 * @return Builder
	 */
	public function options($options = array())
	{
		// Get order options
		$orderBy = array_get($options, 'order_by', 'created_at');
		$order   = array_get($options, 'order',    'desc');

		// Run order
		if ($orderBy == 'rand') $this->query->orderBy(DB::raw('RAND()'), $order);
		else                    $this->query->orderBy($orderBy, $order);

		if (is_array($options))
		{
			foreach ($options as $key => $value)
			{
				if ( ! in_array($key, array('limit', 'order_by')))
				{
					if (is_array($value))
					{
						$this->query->where($key, $value[0], $value[1]);
					}
					else
					{
						$this->query->where($key, $value);
					}
				}
			}
		}

		return $this->query;
	}

	/**
	 * Return single item
	 * @return Entity
	 */
	public function item()
	{
		$item        = $this->query->first();
		$entityClass = $this->entityClass;

		if ($item) return new $entityClass($item->toArray());
		else       return new $entityClass;
	}

	/**
	 * Return validation errors
	 *
	 * @return Illuminate\Support\MessageBag
	 */
	function errors()
	{
		return $this->errors;
	}

}
