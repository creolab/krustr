<?php namespace Krustr\Forms;

class TermForm extends BaseForm implements FormInterface {

	protected $fields = array(
		'title' => array('name' => 'title', 'label' => 'Name',        'type' => 'text',     'save' => 'direct'),
		'slug'  => array('name' => 'slug',  'label' => 'Slug',        'type' => 'text',     'save' => 'direct'),
		'body'  => array('name' => 'body',  'label' => 'Description', 'type' => 'richtext', 'save' => 'direct'),
		'image' => array('name' => 'image', 'label' => 'Image',       'type' => 'image',    'save' => 'direct'),
	);

}
