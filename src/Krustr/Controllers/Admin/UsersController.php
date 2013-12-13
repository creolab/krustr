<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Repositories\Interfaces\UserRepositoryInterface;
use Krustr\Services\Validation\UserValidator;
use Krustr\Forms\UserForm;

class UsersController extends BaseController {

	/**
	 * User repository
	 *
	 * @var UserRepository
	 */
	protected $user;

	/**
	 * Initialize the users section with dependencies
	 *
	 * @return void
	 */
	public function __construct(UserRepositoryInterface $user)
	{
		$this->beforeFilter('krustr.backend.acl.super');

		$this->user = $user;

		View::share('meta_title', 'Users');
	}

	/**
	 * Display list of users
	 *
	 * @return View
	 */
	public function index()
	{
		$users = $this->user->all();

		return View::make('krustr::users.index', array('users' => $users));
	}

	/**
	 * Form to create a new user
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('krustr::users.create');
	}

	/**
	 * Store new user to DB
	 *
	 * @return Redirect
	 */
	public function store()
	{

	}

	/**
	 * Edit specific user
	 *
	 * @param  integer $id
	 * @return View
	 */
	public function edit($id)
	{
		// Get user and prepare the form
		$user = $this->user->find($id);
		$form  = new UserForm($user, array('url' => admin_route('system.users.update', $id)));

		return View::make('krustr::users.edit')->withUser($user)->withForm($form);
	}

	/**
	 * Update existing user
	 *
	 * @param  integer $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$user = $this->user->update($id, Input::all());

		return Redirect::route('backend.system.users.edit', $id);
	}

}
