<?php

require __DIR__.'/../../../vendor/autoload.php';

return [
	'paths' => [
		'migrations' => __DIR__.'/migrations'
	],

	'environments' => [
		'default_database' => '	changeable',
		'default_migration_table' => 'phinxlog_b2_users_activity',
		'	changeable' => [
			'name' => \B2\Cfg::get('b2.changeable.db'),
			'connection' => driver_mysql::factory(\B2\Cfg::get('b2.changeable.db'))->connection(),
		]
	]
];
