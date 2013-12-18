<?php namespace Krustr\Services\Validation;

class FragmentValidator extends Validator {

	protected static $rules = array(
		'title' => 'required',
		'slug'  => 'required',
	);

}
