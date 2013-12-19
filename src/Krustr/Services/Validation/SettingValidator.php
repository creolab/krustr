<?php namespace Krustr\Services\Validation;

class SettingValidator extends Validator {

	protected static $rules = array(
		'title' => 'required',
	);

}
