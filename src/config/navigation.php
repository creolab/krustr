<?php

return array(

	'backend' => array(
		'class'   => 'collapse navbar-collapse navbar-ex1-collapse',
		'view'    => 'krustr::_service.navigation.main',
		'subview' => 'krustr::_service.navigation.sub',

		'items' => array(
			// ! Dashboard
			'dashboard' => array(
				'order' => 100, 'label' => null, 'icon'  => 'home', 'route' => 'backend.dashboard', 'class' => 'home', 'mark'  => 'exact',
			),

			// ! Content
			'content' => array(
				'order' => 200, 'label' => 'Content', 'icon'  => 'pencil', 'route' => 'backend.content',

				// ! ==> Channels (Load from channels configuration)
				'children' => app('config')->get('krustr::channels'),
			),

			// ! Taxonomies
			'taxonomies' => array(
				'order' => 300, 'label' => 'Taxonomies', 'icon'  => 'tasks', 'route' => 'backend.taxonomy',

				// ! ==> Channels (Load from channels configuration)
				'children' => app('config')->get('krustr::taxonomies'),
			),

			// ! System
			'system' => array(
				'order' => 9999, 'label' => 'System', 'icon'  => 'cog', 'route' => 'backend.system',

				'children' => array(
					// ! ==> Users
					'users' => array(
						'order' => 100, 'label' => 'Users', 'icon'  => 'user', 'route' => 'backend.system.users.index',
					),

					// ! ==> Settings
					'settings' => array(
						'order' => 500, 'label' => 'Settings', 'icon'  => 'wrench', 'href' => '#',
					),

					// ! ==> Cache
					'cache' => array(
						'order' => 9999, 'label' => 'Clear cache', 'icon'  => 'trash', 'href' => '#',
					),
				),
			),
		),
	),

);
