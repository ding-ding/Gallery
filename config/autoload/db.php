<?php

return [
    'dbParams' => [
        'database' => 'gallery',
        'username' => 'root',
        'password' => 'toor',
        'hostname' => 'localhost',
		'driver_options' => [
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET UTF8",
		],
    ],
];