<?php

return array(
	'name'              => 'shop',
	'resource'          => 'shop',
	'resource_singular' => 'product',
	'headline'          => 'Shop',
	'title'             => 'Products',
	'title_singular'    => 'Product',
	'icon'              => 'shopping-cart',
	'order'             => 300,

	// ! -- Fields
	'fields' => array(
		// ! -- -- Default
		'title'   => array('name' => 'title',   'label' => 'Title',   'type' => 'text',     'save' => 'direct', 'placeholder' => 'Enter title...', 'css_class' => 'input-lg'),
		'slug'    => array('name' => 'slug',    'label' => 'Slug',    'type' => 'text',     'save' => 'direct'),
		'body'    => array('name' => 'body',    'label' => 'Content', 'type' => 'richtext', 'save' => 'direct'),
		'image'   => array('name' => 'image',   'label' => 'Image',   'type' => 'image'),
		'gallery' => array('name' => 'gallery', 'label' => 'Gallery', 'type' => 'gallery'),
	),
);
