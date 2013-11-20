<?php

return array(
	'name'              => 'blog',
	'resource'          => 'blog',
	'resource_singular' => 'article',
	'headline'          => 'Blog',
	'title'             => 'Articles',
	'title_singular'    => 'Article',
	'icon'              => 'tags',
	'order'             => 100,

	// ! -- Field groups
	'groups' => array(
		// ! Default
		'default' => array(
			'name'   => 'Content',
			'fields' => array(
				'title'   => array('name' => 'title',   'label' => 'Title',   'type' => 'text',     'save' => 'direct', 'placeholder' => 'Enter title...', 'css_class' => 'input-lg'),
				'body'    => array('name' => 'body',    'label' => 'Content', 'type' => 'richtext', 'save' => 'direct'),
			),
		),
		'textual'   => array(
			'name'   => 'Textual',
			'fields' => array(
				'summary' => array('name' => 'summary', 'label' => 'Summary',   'type' => 'richtext'),
				'terms'   => array('name' => 'terms',   'label' => 'Terms',     'type' => 'textarea'),
				'bio'     => array('name' => 'bio',     'label' => 'Biography', 'type' => 'richtext'),
			),
		),
		'media'   => array(
			'name'   => 'Media',
			'fields' => array(
				'image'   => array('name' => 'image',   'label' => 'Image',   'type' => 'image'),
				'gallery' => array('name' => 'gallery', 'label' => 'Gallery', 'type' => 'gallery'),
				'video'   => array('name' => 'video',   'label' => 'Video',   'type' => 'video'),
			),
		),
	),

);
