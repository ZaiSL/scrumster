<?php
defined('ROOT_PATH') OR DEFINE('ROOT_PATH', dirname(dirname(dirname(__FILE__))));
$config = require __DIR__.'/../../app/config/config.php';
 
$loader = new \Phalcon\Loader();
 
$loader->registerDirs(
    array(
                ROOT_PATH . $config->application->controllersDir,
                ROOT_PATH . $config->application->modelsDir,
				ROOT_PATH . $config->application->pluginsDir,
                ROOT_PATH . $config->application->libraryDir,
    )
)->register();

$di = new Phalcon\DI\FactoryDefault\CLI();
$console = new \Phalcon\CLI\Console();
 
$di->set('db', function() use ($config) {
    $db = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host"      => $config->database->host,
        "username"  => $config->database->username,
        "password"  => $config->database->password,
        "dbname"    => $config->database->name
    ));
 
    $db->execute('SET NAMES UTF8',array());
 
    return $db;
});
 
$console->setDI($di);
$console->handle(array());
