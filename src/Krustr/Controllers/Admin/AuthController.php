<?php namespace Krustr\Controllers\Admin;

use Auth, Config, Event, Input, View;
use Krustr\Helpers\Redirect;

/**
 * Controls login and logout routes
 *
 * @author Boris Strahija <boris@creolab.hr>
 */
class AuthController extends BaseController {

	/**
	 * Display login form
	 *
	 * @return View
	 */
	public function getLogin()
	{
		return View::make('krustr::auth.login');
	}

	/**
	 * Attemt a sign in
	 *
	 * @return Redirect
	 */
	public function postLogin()
	{
		// Start
		Event::fire('krustr.auth.logging_in', Input::all());

		// Get credentials from user input
		$credentials = array(
			'email'    => Input::get('email'),
			'password' => Input::get('password')
		);

		// Attempt to login
		if (Auth::attempt($credentials, true))
		{
			Event::fire('krustr.auth.logged_in', $credentials);

			return Redirect::intended(Config::get('krustr::backend_url'));
		}
		else
		{
			Event::fire('krustr.auth.failed_login', $credentials);

			return Redirect::adminRoute('login');
		}
	}

	/**
	 * Terminate the users auth session
	 *
	 * @return Redirect
	 */
	public function getLogout()
	{
		Auth::logout();

		return Redirect::adminRoute('login');
	}

}
