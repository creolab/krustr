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
	| Image dimmensions
	|--------------------------------------------------------------------------
	|
	| All uploaded media will be resized to these dimmensions when uploaded
	| Additionally you can define dimmensions for each field if needed
	|
	| A dimmensions consists of the following: array(width, height, crop, quality)
	|
	*/
	'image_dimmensions' => array(
		'thumb'  => array(100, 100, true,  80),
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
