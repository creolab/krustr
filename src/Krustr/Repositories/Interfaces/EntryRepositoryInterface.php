<?php namespace Krustr\Repositories\Interfaces;

/**
 * Interface for content entry repositories
 * @author Boris Strahija <bstrahija@gmail.com>
 */
interface EntryRepositoryInterface {

	public function all();
	public function allInChannel($channel);
	public function home();
	public function find($id, $options);
	public function findPublished($id);
	public function findBySlug($slug, $channel = null, $options = array());
	public function findPublishedBySlug($slug, $channel = null);
	public function update($id, $data);
	public function create($data);
	public function publish($id);
	public function unpublish($id);

}
