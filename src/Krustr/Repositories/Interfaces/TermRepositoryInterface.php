<?php namespace Krustr\Repositories\Interfaces;

interface TermRepositoryInterface {

	public function all();
	public function find($entryId);
	public function create();
	public function update($id);
	public function createOrUpdate();
	public function exists($name);

}
