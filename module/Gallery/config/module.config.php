<?php
return [
    'router' => [
		'routes' => [
			'gallery' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route' => '/gallery',
					'defaults' => [
						'__NAMESPACE__' => 'Gallery\Controller',
						'controller'  => 'Album',
						'action'	  => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type' => 'Zend\Mvc\Router\Http\Segment',
						'options' => [
							'route' => '/[:controller[/:action[/:id]]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'	 => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'		 => '[0-9]+',
							],
							'defaults' => [
								
							],
						],
					],
				],
			],
		],
	],
	
	'controllers' => [
		'invokables' => [
			'Gallery\Controller\Album' => 'Gallery\Controller\AlbumController',
			'Gallery\Controller\Photo' => 'Gallery\Controller\PhotoController',
		],
	],
	
	'view_manager' => [
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
];