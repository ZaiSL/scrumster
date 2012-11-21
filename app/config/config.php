<?php

return new \Phalcon\Config(array(
	'database' => array(
		'adapter'  => 'Mysql',
		'host'     => 'localhost',
		'username' => 'root',
		'password' => '',
		'name'     => 'scrumster',
	),
	'application' => array(
		'publicDir'         =>  '/public/',
		'controllersDir'    =>  '/app/controllers/',
		'modelsDir'         =>  '/app/models/',
		'viewsDir'          =>  '/app/views/',
		'pluginsDir'        =>  '/app/plugins/',
		'libraryDir'        =>  '/app/library/',
        'widgetsDir'        =>  '/app/widgets/',
		'helpersDir'        =>  '/app/helpers/',
		'baseUri'           => 'http://www.scrumster.local',
	),
	'models' => array(
		'metadata' => array(
			'adapter'   => 'Memory',
			'suffix'    => 'local'
		)
	)
));
