<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Forms\FragmentForm;
use Krustr\Repositories\Interfaces\FragmentRepositoryInterface;
use Krustr\Services\Validation\FragmentValidator;

class FragmentsController extends BaseController {

	/**
	 * Repositry for fragments data
	 * @var FragmentRepositoryInterface
	 */
	protected $fragments;

	/**
	 * Init dependecies
	 * @param FragmentRepositoryInterface $fragments
	 */
	public function __construct(FragmentRepositoryInterface $fragments)
	{
		$this->fragments = $fragments;
	}

	/**
	 * Display all indexes
	 * @return View
	 */
	public function index()
	{
		$fragments = $this->fragments->all();

		return View::make('krustr::fragments.index', array(
			'fragments'  => $fragments,
		));
	}

	/**
	 * Display form for creating new fragment
	 * @return View
	 */
	public function create()
	{
		// Setup form
		$form = new FragmentForm(null, array('route' => 'content.fragments.store'));

		return View::make('krustr::fragments.create', array('form' => $form));
	}

	/**
	 * Store a new form
	 * @return Redirect
	 */
	public function store()
	{
		if ($id = $this->fragments->create(Input::all()))
		{
			return Redirect::route('backend.content.fragments.edit', $id)->withAlertSuccess("Saved.");
		}

		return Redirect::back()->withInput()->withErrors($this->fragments->errors());
	}

	/**
	 * Edit an existing fragment
	 * @param  integer $id
	 * @return View
	 */
	public function edit($id)
	{
		// Get fragment and prepare form
		$fragment = $this->fragments->find($id);
		$form     = new FragmentForm($fragment, array('route' => array('content.fragments.update', $id)));

		return View::make('krustr::fragments.edit', array('fragment' => $fragment, 'form' => $form));
	}

	/**
	 * Update existing fragment
	 * @param  integer $id
	 * @return Redirect
	 */
	public function update($id)
	{
		if ($this->fragments->update($id, Input::all()))
		{
			return Redirect::back()->withAlertSuccess('Saved.');
		}

		return Redirect::back()->withInput()->withErrors($this->fragments->errors());
	}

	/**
	 * Delete a fragment
	 * @param  integer $id
	 * @return Redirect
	 */
	public function destroy($id)
	{

	}

}
