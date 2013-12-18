<?php namespace Krustr\Services\Validation;

class TermValidator extends Validator {

	protected static $rules = array(
		'title' => 'required',
	);

}
