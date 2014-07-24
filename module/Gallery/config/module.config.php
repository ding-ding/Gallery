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

    'service_manager' => [
        'factories' => [
            'Gallery\Mapper\Album' => function ($sm) {
                return new \Gallery\Mapper\Album(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },

            'Zend\Db\Adapter\Adapter' => function ($sm) {
                $config = $sm->get('Config');
                $dbParams = $config['dbParams'];

                return new Zend\Db\Adapter\Adapter([
                    'driver' => 'pdo',
                    'dsn' =>
                        'mysql:dbname=' . $dbParams['database']
                        . ';host=' . $dbParams['hostname'],
                    'database' => $dbParams['database'],
                    'username' => $dbParams['username'],
                    'password' => $dbParams['password'],
                    'hostname' => $dbParams['hostname'],
					'driver_options' => $dbParams['driver_options'],
                ]);
            }
        ],
    ],
];