<?php

defined('ROOT_PATH') OR DEFINE('ROOT_PATH', dirname(dirname(__FILE__)));

if (preg_match("|api\/|",$_SERVER['REQUEST_URI'])) {
	DEFINE('PH_DEBUG',  false );
}
else {
	DEFINE('PH_DEBUG',  true );
}
//DEFINE('PH_DEBUG',  (isset( $_SERVER['PHDEBUG'] ) || isset($_COOKIE['PHDEBUG'])) );

switch (PH_DEBUG) {

	// отладка - показываем малейшие ошибки
	case true:

		// рассчет времени работы
		define('PH_DEBUG_TIME_EXECUTION', microtime(true));
		// рассчет памяти
		define('PH_DEBUG_MEM_USAGE', memory_get_usage());

		$options = array(
			'snippet_num_lines' => 10,
			'background_text'  => 'Error!',
			'error_reporting_off' => 0,
			'error_reporting_on' => E_ALL | E_NOTICE | E_STRICT | E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR
		);

		require_once '../app/library/PHPError.php';
		\php_error\reportErrors($options);

		break;

	// продакшен - ошибки не показываем, всё скрываем
	case false:

		error_reporting(0);
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);

		break;
}

// Using require once because I want to get the specific
// bootloader class here. The loader will be initialized
// in my bootstrap class
require_once ROOT_PATH . '/app/library/Ph/Bootstrap.php';
require_once ROOT_PATH . '/app/library/Ph/Error.php';

$di  = new \Phalcon\DI\FactoryDefault();
$di->set('dispatcher', function() use ($di) {

    $eventsManager = $di->getShared('eventsManager');
    $security = new Security($di);
    $eventsManager->attach('dispatch', $security);
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});

$app = new \Ph\Bootstrap($di);

echo $app->run(array());
