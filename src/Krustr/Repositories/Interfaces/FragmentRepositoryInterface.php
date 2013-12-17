<?php namespace Krustr\Repositories\Interfaces;

interface FragmentRepositoryInterface {

	public function all();
	public function find($id);
	public function findBySlug($slug);
	public function create($data);
	public function update($id, $data);
	public function createOrUpdate($data);
	public function exists($slug);

}
