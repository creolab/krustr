<?php namespace Krustr\Forms;

class UserForm extends BaseForm implements FormInterface {

	protected $fields = array(
		'email'            => array('name' => 'email',           'label' => 'Email',            'type' => 'text',     'save' => 'direct'),
		'password'         => array('name' => 'password',        'label' => 'Password',         'type' => 'password', 'save' => 'direct'),
		'confirm_password' => array('name' => 'cofirm_password', 'label' => 'Confirm password', 'type' => 'password', 'save' => 'direct'),
		'bio'              => array('name' => 'bio',             'label' => 'Biography',        'type' => 'richtext', 'save' => 'direct'),
		'photo'            => array('name' => 'photo',           'label' => 'User photo',       'type' => 'image',    'save' => 'direct'),
	);

}
