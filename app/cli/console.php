<?php
//https://gist.github.com/3658914
error_reporting(E_ALL);

try {
	defined('ROOT_PATH') OR DEFINE('ROOT_PATH', dirname(dirname(dirname(__FILE__))));
	$config = require __DIR__.'/../../app/config/config.php';

	$loader = new \Phalcon\Loader();

	$loader->registerDirs(
		array(
			ROOT_PATH.$config->application->controllersDir,
			ROOT_PATH.$config->application->pluginsDir,
			ROOT_PATH.$config->application->libraryDir,
			ROOT_PATH.$config->application->modelsDir,
			ROOT_PATH.$config->application->tasksDir,
		)
	)->register();

	$di = new \Phalcon\DI\FactoryDefault\CLI();
	$di->set('db', function() use ($config) {
		return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
			"host" => $config->database->host,
			"username" => $config->database->username,
			"password" => $config->database->password,
			"dbname" => $config->database->name
		));
	});

	$console = new \Phalcon\CLI\Console();
	$console->setDI($di);
	$console->handle($_SERVER['argv']);

} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}
