<?php namespace Krustr\Repositories\Interfaces;

/**
 * Interface for content entry repositories
 * @author Boris Strahija <bstrahija@gmail.com>
 */
interface EntryRepositoryInterface {

	public function all();
	public function allInChannel($channel);
	public function home();
	public function find($id);
	public function findBySlug($slug);
	public function update($id, $data);
	public function create($data);
	public function publish($id);
	public function unpublish($id);

}
