<?php

return array(

	'backend' => array(
		'class'   => 'collapse navbar-collapse navbar-ex1-collapse',
		'view'    => 'krustr::_service.navigation.main',
		'subview' => 'krustr::_service.navigation.sub',

		'items' => array(
			// ! Dashboard
			'dashboard' => array(
				'order' => 100, 'label' => null, 'icon'  => 'home', 'route' => 'backend.dashboard', 'class' => 'home', 'mark'  => 'exact',  'role' => 'editor',
			),

			// ! Content
			'content' => array(
				'order' => 200, 'label' => 'Content', 'icon'  => 'pencil', 'route' => 'backend.content', 'role' => 'editor',

				// ! ==> Channels (Load from channels configuration)
				'children' => array_merge(app('config')->get('krustr::channels'), array(

					// ! ==> Fragments
					'fragments' => array(
						'order' => 9000, 'label' => 'Fragments', 'icon'  => 'pencil', 'route' => 'backend.content.fragments.index', 'role' => 'editor', 'li_class' => 'pull-right', 'separated' => true,
					),
				)),
			),

			// ! Taxonomies
			'taxonomies' => array(
				'order' => 300, 'label' => 'Taxonomies', 'icon'  => 'tasks', 'route' => 'backend.taxonomy', 'role' => 'admin',

				// ! ==> Taxonomies (Load from taxonomy configuration)
				'children' => app('config')->get('krustr::taxonomies'),
			),

			// ! System
			'system' => array(
				'order' => 9999, 'label' => 'System', 'icon'  => 'cog', 'route' => 'backend.system', 'role' => 'super',

				'children' => array(
					// ! ==> Users
					'users' => array(
						'order' => 100, 'label' => 'Users', 'icon'  => 'user', 'route' => 'backend.system.users.index',
					),

					// ! ==> Settings
					'settings' => array(
						'order' => 500, 'label' => 'Settings', 'icon'  => 'wrench', 'route' => 'backend.system.settings.index',
					),

					// ! ==> Cache
					'cache' => array(
						'order' => 9999, 'label' => 'Clear cache', 'icon'  => 'trash', 'route' => 'backend.system.clear_cache',
					),
				),
			),
		),
	),

);
