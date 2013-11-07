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

	// ! -- Fields
	'fields' => array(
		// ! -- -- Default
		'title'   => array('name' => 'title',   'label' => 'Title',   'type' => 'text',     'save' => 'direct', 'placeholder' => 'Enter title...', 'css_class' => 'input-lg'),
		'slug'    => array('name' => 'slug',    'label' => 'Slug',    'type' => 'text',     'save' => 'direct'),
		'body'    => array('name' => 'body',    'label' => 'Content', 'type' => 'richtext', 'save' => 'direct'),
		'expires' => array('name' => 'expires', 'label' => 'Expires', 'type' => 'date'),
		'terms'   => array('name' => 'terms',   'label' => 'Terms',   'type' => 'textarea'),
		'image'   => array('name' => 'image',   'label' => 'Image',   'type' => 'image'),
		'gallery' => array('name' => 'gallery', 'label' => 'Gallery', 'type' => 'gallery'),
	),
);
