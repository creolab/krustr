<?php

return array(

	'theme.css' => array(
		'assets' => array(
			'css/bootstrap.min.css',
			'css/style.css',
		),
		'filters' => array('cssmin'),
		'combine' => true,
	),

	'theme.js' => array(
		'assets' => array(
			'js/jquery.min.js',
			'js/bootstrap.min.js',
			'js/app.js',
			'js/init.js',
		),
		'filters' => array('jsmin'),
		'combine' => false,
	),

);
