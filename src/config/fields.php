<?php

return array(

	// ! Text
	'text' => array(
		'class' => '\Krustr\Forms\Fields\Text\TextField',
		'view'  => 'krustr_fields::Text.views.text_field',
		'icon'  => 'pencil',
	),

	// ! Password
	'password' => array(
		'class' => '\Krustr\Forms\Fields\Password\PasswordField',
		'view'  => 'krustr_fields::Password.views.password_field',
		'icon'  => 'lock',
	),

	// ! Textarea (multiline)
	'textarea' => array(
		'class' => '\Krustr\Forms\Fields\Textarea\TextareaField',
		'view'  => 'krustr_fields::Textarea.views.textarea_field',
		'icon'  => 'pencil',
	),

	// ! Richtext (WYSIWYG)
	'richtext' => array(
		'class' => '\Krustr\Forms\Fields\Richtext\RichtextField',
		'view'  => 'krustr_fields::Richtext.views.richtext_field',
		'icon'  => 'book',
	),

	// ! Image uploder
	'image' => array(
		'class' => '\Krustr\Forms\Fields\Image\ImageField',
		'view'  => 'krustr_fields::Image.views.image_field',
		'icon'  => 'picture',
	),

	// ! Gallery manager
	'gallery' => array(
		'class' => '\Krustr\Forms\Fields\Gallery\GalleryField',
		'view'  => 'krustr_fields::Gallery.views.gallery_field',
		'icon'  => 'picture',
	),

	// ! Video field
	'video' => array(
		'class' => '\Krustr\Forms\Fields\Video\VideoField',
		'view'  => 'krustr_fields::Video.views.video_field',
		'icon'  => 'film',
	),

	// ! Selectbox
	'selectbox' => array(
		'class' => '\Krustr\Forms\Fields\Selectbox\SelectboxField',
		'view'  => 'krustr_fields::Selectbox.views.selectbox_field',
		'icon'  => 'th-list',
	),

	// ! Datepicker
	'date' => array(
		'class' => '\Krustr\Forms\Fields\Date\DateField',
		'view'  => 'krustr_fields::Date.views.date_field',
		'icon'  => 'calendar',
	),

	// ! Timepicker
	'time' => array(
		'class' => '\Krustr\Forms\Fields\Time\TimeField',
		'view'  => 'krustr_fields::Date.views.time_field',
		'icon'  => 'dashboard',
	),

	// ! Date and time picker
	'datetime' => array(
		'class' => '\Krustr\Forms\Fields\Datetime\DatetimeField',
		'view'  => 'krustr_fields::Datetime.views.datetime_field',
		'icon'  => 'calendar',
	),

);
