<?php namespace Krustr\Repositories\Interfaces;

interface FieldRepositoryInterface {

	public function all($entryId);
	public function get($entryId, $key);
	public function add($entryId, $key, $value);
	public function update($entryId, $key, $value);
	public function addOrUpdate($entryId, $key, $value);
	public function exists($entryId, $key);
	public function saveForEntry($entryId, $data);

}
