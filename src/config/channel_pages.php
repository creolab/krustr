<?php

return array(
	'name'              => 'pages',
	'resource'          => 'pages',
	'resource_singular' => 'page',
	'title'             => 'Pages',
	'title_singular'    => 'Page',
	'icon'              => 'book',
	'order'             => 200,

	// ! -- Fields
	'fields' => array(
		// ! -- -- Default
		'title'     => array('name' => 'title',    'label' => 'Title',    'type' => 'text',     'save' => 'direct', 'placeholder' => 'Enter title...', 'css_class' => 'input-lg'),
		'slug'      => array('name' => 'slug',     'label' => 'Slug',     'type' => 'text',     'save' => 'direct'),
		'body'      => array('name' => 'body',     'label' => 'Content',  'type' => 'richtext', 'save' => 'direct'),
		'selector'  => array('name' => 'selector', 'label' => 'Selector', 'type' => 'selectbox', 'placeholder' => 'Pick one'),
		'mulsel'    => array('name' => 'mulsel',   'label' => 'Multisel', 'type' => 'selectbox', 'multiple' => true, 'placeholder' => 'Pick more than one'),
	),
);
