<?php namespace Krustr\Repositories;

use Krustr\Models\User;
use Krustr\Repositories\Collections\UserCollection;
use Krustr\Repositories\Entities\UserEntity;

class UserDbRepository extends DbRepository implements Interfaces\UserRepositoryInterface{

	/**
	 * Get all users
	 *
	 * @return UserCollection
	 */
	public function all()
	{
		$users = User::all()->toArray();

		return new UserCollection($users);
	}

	/**
	 * Find specific user by id
	 *
	 * @param  integer $id
	 * @return EntryEntity
	 */
	public function find($id)
	{
		$entry = User::findOrFail($id)->toArray();

		return new UserEntity($entry);
	}

	/**
	 * Update exiting content entry
	 * @param  integer $id
	 * @param  array   $data
	 * @return boolean
	 */
	public function update($id, $data = array())
	{
		/*$entry = Entry::find($id);
		$entry->title = array_get($data, 'title');
		$entry->body  = array_get($data, 'body');

		return $entry->save();*/
	}

	/**
	 * Create new entry
	 * @param  array $data
	 * @return boolean
	 */
	public function create($data)
	{

	}

}
