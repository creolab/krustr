<?php namespace Krustr\Forms\Fields\Date;

class DateField extends \Krustr\Forms\Fields\Field {

	/**
	 * Reformat the value
	 *
	 * @return mixed
	 */
	function value()
	{
		return \Carbon\Carbon::createFromTimeStamp(strtotime($this->value));
	}

}
