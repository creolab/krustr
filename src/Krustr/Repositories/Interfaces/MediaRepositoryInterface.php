<?php namespace Krustr\Repositories\Interfaces;

interface MediaRepositoryInterface {

	public function find($id);
	public function create($data);
	public function update($id, $data);
	public function destroy($id);

}
