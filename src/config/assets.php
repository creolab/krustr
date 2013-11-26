<?php

return array(

	'app_css' => array(
		'name'   => 'app.css',
		'type'   => 'css',
		'assets' => array(
			'vendor/bootstrap/bootstrap.min.css',
			'vendor/font-awesome/font-awesome.min.css',
			'vendor/select2/select2.css',
			'vendor/fancybox/jquery.fancybox.css',
			'vendor/alertify/themes/alertify.core.css',
			'vendor/alertify/themes/alertify.default.css',
			'vendor/datepicker/css/datepicker.css',
			'css/app.css',
			'css/navigation.css',
			'css/forms.css',
			'css/tables.css',
			'css/login.css',
		),
		'filters' => array(),
		'combine' => true,
	),

	'app_js' => array(
		'name'   => 'app.js',
		'type'   => 'js',
		'assets' => array(
			'vendor/jquery.min.js',
			'vendor/underscore.js',
			'vendor/bootstrap/bootstrap.min.js',
			'vendor/ckeditor/ckeditor.js',
			'vendor/select2/select2.min.js',
			'vendor/plupload/plupload.full.js',
			'vendor/alertify/alertify.js',
			'vendor/fancybox/jquery.fancybox.js',
			'vendor/datepicker/js/bootstrap-datepicker.js',
			'vendor/timepicker/bootstrap-timepicker.min.js',
			'js/app.js',
			'js/ajax.js',
			'js/forms.js',
			'js/upload.js',
			'js/init.js',
		),
		'filters' => array(),
		'combine' => true,
	),

);
