<?php namespace Krustr\Forms;

class FragmentForm extends BaseForm implements FormInterface {

	protected $fields = array(
		'title' => array('name' => 'title', 'label' => 'Name', 'type' => 'text',     'save' => 'direct'),
		'slug'  => array('name' => 'slug',  'label' => 'Slug', 'type' => 'text',     'save' => 'direct'),
		'body'  => array('name' => 'body',  'label' => 'Body', 'type' => 'richtext', 'save' => 'direct'),
	);

}
