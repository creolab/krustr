<?php

return array(

	// ! Text
	'text' => array(
		'class' => '\Krustr\Forms\Fields\Text\TextField',
		'view'  => 'krustr_fields::text.views.text_field',
		'icon'  => 'pencil',
	),

	// ! Password
	'password' => array(
		'class' => '\Krustr\Forms\Fields\Password\PasswordField',
		'view'  => 'krustr_fields::password.views.password_field',
		'icon'  => 'lock',
	),

	// ! Textarea (multiline)
	'textarea' => array(
		'class' => '\Krustr\Forms\Fields\Textarea\TextareaField',
		'view'  => 'krustr_fields::textarea.views.textarea_field',
		'icon'  => 'pencil',
	),

	// ! Richtext (WYSIWYG)
	'richtext' => array(
		'class' => '\Krustr\Forms\Fields\Richtext\RichtextField',
		'view'  => 'krustr_fields::richtext.views.richtext_field',
		'icon'  => 'book',
	),

	// ! Image uploder
	'image' => array(
		'class' => '\Krustr\Forms\Fields\Image\ImageField',
		'view'  => 'krustr_fields::image.views.image_field',
		'icon'  => 'picture',
	),

	// ! Gallery manager
	'gallery' => array(
		'class' => '\Krustr\Forms\Fields\Gallery\GalleryField',
		'view'  => 'krustr_fields::gallery.views.gallery_field',
		'icon'  => 'picture',
	),

	// ! Selectbox
	'selectbox' => array(
		'class' => '\Krustr\Forms\Fields\Selectbox\SelectboxField',
		'view'  => 'krustr_fields::selectbox.views.selectbox_field',
		'icon'  => 'th-list',
	),

	// ! Datepicker
	'date' => array(
		'class' => '\Krustr\Forms\Fields\Date\DateField',
		'view'  => 'krustr_fields::date.views.date_field',
		'icon'  => 'calendar',
	),

	// ! Timepicker
	'time' => array(
		'class' => '\Krustr\Forms\Fields\Time\TimeField',
		'view'  => 'krustr_fields::date.views.time_field',
		'icon'  => 'dashboard',
	),

	// ! Date and time picker
	'datetime' => array(
		'class' => '\Krustr\Forms\Fields\Datetime\DatetimeField',
		'view'  => 'krustr_fields::datetime.views.datetime_field',
		'icon'  => 'calendar',
	),

);
