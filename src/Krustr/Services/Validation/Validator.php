<?php namespace Krustr\Services\Validation;

use Input;

/**
 * Base validator class for Krustr backend
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
abstract class Validator {

	/**
	 * Input data for validation
	 *
	 * @var array
	 */
	protected $input;

	/**
	 * Validation errors
	 *
	 * @var array
	 */
	protected $errors;

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected static $rules;

	/**
	 * Initialize new validator
	 * @param array $input
	 */
	public function __construct(array $input = null)
	{
		if ($input) $this->input = $input;
		else        $this->input = Input::all();
	}

	/**
	 * Validate input against rules
	 *
	 * @return boolean
	 */
	public function passes()
	{
		// Make validator instance
		$validation = \Validator::make($this->input, static::$rules);

		// Run validation and get errors
		if ($validation->fails())
		{
			$this->errors = $validation->messages();

			return false;
		}

		return true;
	}

	/**
	 * Return all validation errors
	 *
	 * @return array
	 */
	public function errors()
	{
		return $this->errors;
	}

}
