<?php namespace Krustr\Repositories\Interfaces;

interface FieldRepositoryInterface {

	public function all($entryId);
	public function find($entryId, $key);
	public function findById($id);
	public function create($entryId, $key, $value);
	public function update($entryId, $key, $value);
	public function createOrUpdate($entryId, $key, $value);
	public function exists($entryId, $key);
	public function saveAllForEntry($entryId, $data);
	public function destroy($fieldId);

}
