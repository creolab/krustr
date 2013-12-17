<?php namespace Krustr\Controllers\Admin;

use Alert, Input, Redirect, Request, View;
use Krustr\Helpers\Route;
use Krustr\Forms\FragmentForm;
use Krustr\Repositories\Interfaces\FragmentRepositoryInterface;
use Krustr\Services\Validation\FragmentValidator;

class FragmentsController extends BaseController {

	protected $fragments;

	public function __construct(FragmentRepositoryInterface $fragments)
	{
		$this->fragments = $fragments;
	}

	public function index()
	{
		$fragments = $this->fragments->all();

		return View::make('krustr::fragments.index', array(
			'fragments'  => $fragments,
		));
	}

	public function create()
	{
		// Setup form
		$form = new FragmentForm(null, array('url' => admin_route('content.fragments.store')));

		return View::make('krustr::fragments.create', array('form' => $form));
	}

	public function store()
	{

	}

	public function edit($id)
	{
		// Get fragment and prepare form
		$fragment = $this->fragments->find($id);
		$form     = new FragmentForm($fragment, array('url' => admin_route('content.fragments.update')));


		return View::make('krustr::fragments.edit', array('fragment' => $fragment, 'form' => $form));
	}

	public function update($id)
	{

	}

	public function destroy($id)
	{

	}

}
