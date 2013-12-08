<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Upload path
	|--------------------------------------------------------------------------
	|
	| Base path for uploading all media
	|
	*/
	'upload_path' => public_path() . '/storage/media/',

	/*
	|--------------------------------------------------------------------------
	| Image dimensions
	|--------------------------------------------------------------------------
	|
	| All uploaded media will be resized to these dimensions when uploaded
	| Additionally you can define dimensions for each field if needed
	|
	| A dimensions consists of the following: array(width, height, crop, quality)
	|
	*/
	'image_dimensions' => array(
		'thumb'  => array(150, 150, true,  80),
		'medium' => array(600, 400, false, 90),
	),

	/*
	|--------------------------------------------------------------------------
	| Upload tmp path and url
	|--------------------------------------------------------------------------
	|
	| Temporary upload path
	|
	*/
	'tmp_url'  => '/storage/tmp/',
	'tmp_path' => public_path() . '/storage/tmp/',

);
