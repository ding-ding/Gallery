<?php
return [
    'router' => [
		'routes' => [
			'gallery' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route' => '/',
					'defaults' => [
						'__NAMESPACE__' => 'Gallery\Controller',
						'controller'  => 'Album',
						'action'	  => 'index',
					],
				],
			],
			'album' => [
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route' => '/album[/:action[/:id]]',
					'constarints' => [
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+',
					],
					'defaults' => [
						'__NAMESPACE__' => 'Gallery\Controller',
						'controller' => 'Album',
						'action' => 'index',
					],
				],
			],
			'photo' => [
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route' => '/photo[/:action[/:id]]',
					'constarints' => [
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+',
					],
					'defaults' => [
						'__NAMESPACE__' => 'Gallery\Controller',
						'controller' => 'Photo',
						'action' => 'index',
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
					
			'Gallery\Mapper\Photo' => function ($sm) {
                return new \Gallery\Mapper\Photo(
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
            },

            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],

    'navigation' => [
        'default' => [
            [
                'label' => 'Альбомы',
                'route' => 'album',
                'pages' => [
                    [
                        'label' => 'Создание альбома',
                        'route' => 'album',
                        'action' => 'create',
                    ],
                    [
                        'label' => 'Редактирование альбома',
                        'route' => 'album',
                        'action' => 'edit',
                    ],
                    [
                        'label' => 'Удалить',
                        'route' => 'album',
                        'action' => 'delete',
                    ],
                    [
                        'label' => 'Просмотр альбома',
                        'route' => 'album',
                        'action' => 'view',
                    ],
                ],
            ],
        ],
    ],
];