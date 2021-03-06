<?php namespace Krustr\Repositories\Interfaces;

interface TermRepositoryInterface {

	public function all($taxonomyId);
	public function find($slug);
	public function create($data);
	public function update($id, $data);
	public function createOrUpdate();
	public function exists($name);

}
