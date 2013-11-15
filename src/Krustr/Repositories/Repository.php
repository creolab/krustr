<?php namespace Krustr\Repositories;

use Validator;

abstract class Repository {

	/**
	 * Validation errors
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $errors;

	/**
	 * Validation errors
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $validation;

	/**
	 * Return validation errors
	 *
	 * @return Illuminate\Support\MessageBag
	 */
	function errors()
	{
		return $this->errors;
	}

}
