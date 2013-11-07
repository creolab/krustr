<?php namespace Krustr\Services\Validation;

/**
 * Content entry validation service
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class EntryValidator extends Validator {

	protected static $rules = array(
		'title' => 'required',
	);

}
