<?php namespace Krustr\Forms;

interface FormInterface {

	public function openForm();
	public function hiddenFields();
	public function closeForm();
	public function render();
	public function renderField($field, $name);

}
