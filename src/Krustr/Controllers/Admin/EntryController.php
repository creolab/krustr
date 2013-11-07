<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Forms\EntryForm;
use Krustr\Repositories\Interfaces\EntryRepositoryInterface;
use Krustr\Repositories\Interfaces\ChannelRepositoryInterface;
use Krustr\Services\Validation\EntryValidator;

/**
 * Content entries management
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class EntryController extends BaseController {

	/**
	 * Data repository
	 *
	 * @var EntryRepository
	 */
	protected $repository;

	/**
	 * Current channel
	 *
	 * @var ChannelEntity
	 */
	protected $channel;

	/**
	 * Initialize the content section with dependencies
	 *
	 * @param EntryRepositoryInterface    $repository
	 * @param ChannelRepositoryInterface  $channelRepository
	 */
	public function __construct(EntryRepositoryInterface $repository, ChannelRepositoryInterface $channelRepository)
	{
		$this->repository        = $repository;
		$this->channelRepository = $channelRepository;
		$this->channel           = Route::adminChannel();

		View::share('channel', $this->channel);
		View::share('meta_title', 'Content / ' . ucfirst($this->channel->name));
	}

	/**
	 * List all entries
	 *
	 * @return View
	 */
	public function index()
	{
		Alert::addSuccess("Saved");
		Alert::addError("Not saved");
		Alert::addError("Or maybe not saved");
		Alert::addWarning("Your message is missing");

		echo '<pre>'; print_r(var_dump(Alert::bag())); echo '</pre>';


		echo Alert::render();

		die();

		// Find in database
		$entries = $this->repository->allInChannel($this->channel->name);

		return View::make('krustr::entries.index', array('entries' => $entries));
	}

	/**
	 * Display form for creating a new entry
	 *
	 * @return View
	 */
	public function create()
	{
		$form = new EntryForm($this->channel);

		return View::make('krustr::entries.create', array('form' => $form));
	}

	/**
	 * Store a new entry to the DB
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$this->repository->create(Input::all());

		return Redirect::route('backend.content.'.$this->channel->name.'.edit', array(1))->withAlertSucces("Saved.");
	}

	/**
	 * Preview single entry
	 *
	 * @param  integer $id
	 * @return View
	 */
	public function show($id)
	{
		// Get requested entry
		$entry = $this->repository->find($id, $this->channel->name);

		return View::make('krustr::entries.show')->withEntry($entry);
	}

	/**
	 * Display a form for entry editing
	 *
	 * @param  integer $id
	 * @return View
	 */
	public function edit($id)
	{
		// Get entry and prepare the form
		$entry = $this->repository->find($id, $this->channel->name);
		$form  = new EntryForm($this->channel, $entry);

		return View::make('krustr::entries.edit')->withEntry($entry)->withForm($form);
	}

	/**
	 * Update an entry via a PUT request
	 *
	 * @param  integer $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$validation = new EntryValidator;

		if ($validation->passes())
		{
			$this->repository->update($id, Input::all());

			return Redirect::back()->withAlertSuccess('Saved.');
		}

		return Redirect::back()->withInput()->withErrors($validation->errors());
	}

	/**
	 * Delete the entry
	 *
	 * @param  integer $id
	 * @return Redirect
	 */
	public function destroy($id)
	{
		// Get requested entry
		$entry = $this->repository->find($id, $this->channel->name);
	}

}
