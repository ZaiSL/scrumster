<?php

defined('ROOT_PATH') OR define('ROOT_PATH', dirname(dirname(__FILE__)));

// режим работы окружения
DEFINE('PH_DEBUG',  (isset( $_SERVER['PHDEBUG'] ) || isset($_COOKIE['PHDEBUG'])) );


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

try {

	/**
	 * Read the configuration
	 */
	$config = include(__DIR__."/../app/config/config.php");

	$loader = new \Phalcon\Loader();

	/**
	 * We're a registering a set of directories taken from the configuration file
	 */
	$loader->registerDirs(
		array(
			$config->application->controllersDir,
			$config->application->libraryDir,
			$config->application->modelsDir,
			$config->application->helpersDir,
			$config->application->widgetsDir,
			$config->application->pluginsDir,
		)
	)->register();

	/**
	 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
	 */
	$di = new \Phalcon\DI\FactoryDefault();

	$di->set('config',$config);
	
	/**
	 * The URL component is used to generate all kind of urls in the application
	 */
	$di->set('url', function() use ($config) {
		
		$url = new \Phalcon\Mvc\Url();
		$url->setBaseUri($config->application->baseUri);
		return $url;
	});


	$di->set('router', function(){

		return require (__DIR__.'/../app/config/routes.php');
	});


	/**
	 * Setting up the view component
	 */
	$di->set('view', function() use ($config) {
		
		$view = new \Phalcon\Mvc\View();
		$view->setViewsDir($config->application->viewsDir);
		return $view;
	});

	/**
	 * Database connection is created based in the parameters defined in the configuration file
	 */
	$di->set('db', function() use ($config,$di) {

		if( PH_DEBUG ){

			$di->set('profiler', function(){
				return new Phalcon\Db\Profiler();
			});

			$eventsManager = new Phalcon\Events\Manager();

			//Get a shared instance of the DbProfiler
			$profiler = $di->getShared('profiler',array());

			//Listen all the database events
			$eventsManager->attach('db', function($event, $connection) use ($profiler) {
				if ($event->getType() == 'beforeQuery') {
					$profiler->startProfile($connection->getSQLStatement());
				}
				if ($event->getType() == 'afterQuery') {
					$profiler->stopProfile();
				}
			});
		}

		$db = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
			"host" => $config->database->host,
			"username" => $config->database->username,
			"password" => $config->database->password,
			"dbname" => $config->database->name
		));

		//Assign the eventsManager to the db adapter instance
		PH_DEBUG ? $db->setEventsManager($eventsManager) : null;

		$db->execute('SET NAMES UTF8',array());

		return $db;
	});

	/**
	 * If the configuration specify the use of metadata adapter use it or use memory otherwise
	 */
	$di->set('modelsMetadata', function() use ($config) {
		if (isset($config->models->metadata)) {
			$metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\'.$config->models->metadata->adapter;
			return new $metadataAdapter( array("suffix" => $config->models->metadata->suffix ) );
		} else {
			return new \Phalcon\Mvc\Model\Metadata\Memory( array("suffix" => $config->models->metadata->suffix ) );
		}
	});

	/**
	 * Start the session the first time some component request the session service
	 */
	$di->set('session', function() {
		
		$session = new \Phalcon\Session\Adapter\Files();
		$session->start();
		return $session;
	});
	
	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application();

	$application->setDI($di);

	echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}


// Using require once because I want to get the specific
// bootloader class here. The loader will be initialized
// in my bootstrap class
require_once ROOT_PATH . '/app/library/Ph/Bootstrap.php';
require_once ROOT_PATH . '/app/library/Ph/Error.php';

$di  = new \Phalcon\DI\FactoryDefault();
$app = new \Ph\Bootstrap($di);

echo $app->run(array());