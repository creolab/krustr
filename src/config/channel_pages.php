<?php

return array(
	'name'              => 'pages',
	'resource'          => 'pages',
	'resource_singular' => 'page',
	'title'             => 'Pages',
	'title_singular'    => 'Page',
	'icon'              => 'book',
	'order'             => 200,

	// ! -- Field groups
	'groups' => array(
		// ! Default
		'default' => array(
			'name'   => 'Content',
			'icon'   => 'bullhorn',
			'fields' => array(
				'title'   => array('name' => 'title',   'label' => 'Title',   'type' => 'text',     'save' => 'direct', 'placeholder' => 'Enter title...', 'css_class' => 'input-lg'),
				'body'    => array('name' => 'body',    'label' => 'Content', 'type' => 'richtext', 'save' => 'direct'),
			),
		),
		'test'   => array(
			'name'   => 'Test',
			'icon'   => 'bullhorn',
			'fields' => array(
				'summary'   => array('name' => 'summary', 'label' => 'Summary',   'type' => 'richtext'),
				'selector'  => array('name' => 'selector', 'label' => 'Selector', 'type' => 'selectbox', 'placeholder' => 'Pick one'),
				'mulsel'    => array('name' => 'mulsel',   'label' => 'Multisel', 'type' => 'selectbox', 'multiple' => true, 'placeholder' => 'Pick more than one'),
			),
		),
		'media'   => array(
			'name'   => 'Media',
			'icon'   => 'eye-open',
			'fields' => array(
				'image'   => array('name' => 'image',   'label' => 'Image',   'type' => 'image'),
			),
		),
	),

);
