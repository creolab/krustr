<?php namespace Krustr\Forms\Fields;

use View;

interface FieldInterface {

	public function render($value);
	public function save($data);
	public function set($key, $value);

}
