<?php namespace Krustr\Repositories\Entities;

use App, View;
use Krustr\Forms\Fields\FieldException;

class FieldGroupEntity extends Entity {

	/**
	 * Init new field entity
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->fields = new \Krustr\Repositories\Collections\FieldCollection((array) array_get($data, 'fields'));

		array_forget($data, 'fields');
		$this->data = $data;
	}

}
