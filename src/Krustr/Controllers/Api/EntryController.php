<?php namespace Krustr\Controllers\Api;

use Redirect, Response, Request, View;
use Krustr\Models\Channel;
use Krustr\Models\Entry;

/**
 * API controller for content entries
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class EntryController extends BaseController {

	/**
	 * List all entries
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Channel::name()) $entries = Entry::inChannel(Channel::name())->get();
		else                 $entries = Entry::all();

		if ( ! $entries->isEmpty()) return Response::json(array('entries' => $entries->toArray()));
		else                        return Response::json(array());
	}

	/**
	 * Store a new entry to the DB
	 *
	 * @return Response
	 */
	public function store()
	{
		return Response::json();
	}

	/**
	 * Preview single entry
	 *
	 * @param  integer $id
	 * @return Response
	 */
	public function show($id)
	{
		if (Channel::name()) $entry = Entry::inChannel(Channel::name())->where('id', $id)->first();
		else                 $entry = Entry::where('id', $id)->first();

		if ($entry) return Response::json(array('entry' => $entry->toArray()));
		else        return Response::json(array('error' => true, 'code' => 404), 404);
	}

	/**
	 * Update an entry via a PUT request
	 *
	 * @param  integer $id
	 * @return Response
	 */
	public function update($id)
	{
		return Response::json(array('id' => $id));
	}

	/**
	 * Delete the entry
	 *
	 * @param  integer $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return Response::json(array('id' => $id));
	}

}
