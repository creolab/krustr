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
	 *
	 * @param array $input
	 */
	public function __construct(array $input = null)
	{
		if ($input) $this->input = $input;
		else        $this->input = Input::all();
	}

	/**
	 * Return rules for validator
	 *
	 * @return array
	 */
	public function rules()
	{
		return static::$rules;
	}

	/**
	 * Add new rule for a field
	 *
	 * @param  string $field
	 * @param  string $rule
	 * @return void
	 */
	public function addRule($field, $rule = 'required')
	{

	}

	/**
	 * Validate input against rules
	 *
	 * @return boolean
	 */
	public function passes($data = null)
	{
		if ($data) $this->input = $data;

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
