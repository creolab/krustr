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
		'media'   => array(
			'name'   => 'Media',
			'icon'   => 'eye-open',
			'fields' => array(
				'image'   => array('name' => 'image',   'label' => 'Image',   'type' => 'image'),
				'gallery' => array('name' => 'gallery', 'label' => 'Gallery', 'type' => 'gallery'),
			),
		),
	),
);
