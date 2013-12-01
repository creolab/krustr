<?php namespace Krustr\Repositories\Interfaces;

interface TermRepositoryInterface {

	public function all($taxonomyId);
	public function find($taxonomyId, $entryId);
	public function create();
	public function update($id);
	public function createOrUpdate();
	public function exists($name);

}
