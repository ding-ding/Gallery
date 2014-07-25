<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'module_config' => [
		'upload_location' => __DIR__ . '/../../public/images',
	],
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
);
