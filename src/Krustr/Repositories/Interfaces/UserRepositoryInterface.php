<?php namespace Krustr\Repositories\Interfaces;

interface UserRepositoryInterface {

	public function all();
	public function find($id);
	public function update($id, $data);
	public function create($data);

}
