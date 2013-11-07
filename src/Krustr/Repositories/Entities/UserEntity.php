<?php namespace Krustr\Repositories\Entities;

class UserEntity extends Entity {

	/**
	 * Returns user full name
	 *
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

}
