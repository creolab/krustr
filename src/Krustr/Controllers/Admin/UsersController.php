<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Repositories\Interfaces\UserRepositoryInterface;
use Krustr\Services\Validation\UserValidator;

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
	 * Edit specific user
	 *
	 * @param  integer $id
	 * @return View
	 */
	public function edit($id)
	{
		$user = $this->user->find($id);

		return View::make('krustr::users.edit', array('user' => $user));
	}

}
