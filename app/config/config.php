<?php

$root = dirname(dirname(__DIR__));

return new \Phalcon\Config(array(
	'database' => array(
		'adapter'  => 'Mysql',
		'host'     => 'localhost',
		'username' => 'root',
		'password' => '',
		'name'     => 'scrumster',
	),
	'application' => array(
		'publicDir'         => $root . '/public/',
		'controllersDir'    => $root . '/app/controllers/',
		'modelsDir'         => $root . '/app/models/',
		'viewsDir'          => $root . '/app/views/',
		'pluginsDir'        => $root . '/app/plugins/',
		'libraryDir'        => $root . '/app/library/',
        'widgetsDir'        => $root . '/app/widgets/',
		'helpersDir'        => $root . '/app/helpers/',
		'baseUri'           => 'http://www.scrumster.local',
	),
	'models' => array(
		'metadata' => array(
			'adapter'   => 'Memory',
			'suffix'    => 'local'
		)
	)
));
