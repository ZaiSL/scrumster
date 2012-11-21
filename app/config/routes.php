<?php

$router = new Phalcon\Mvc\Router( false );

$router->setDefaults(array(
    'controller' => 'index',
    'action' => 'index',
	'page'=>0
));

/* статичные страницы */
$router->addGet("/{slug:[a-z0-9\-]+}/", array(
	'controller'    => 'pages',
	'action'        => 'pages',
))->setName("pages");

/* тестовая площадка */
$router->addGet("/sandbox/", array(
	'controller'    => 'sandbox',
	'action'        => 'index',
))->setName("sandbox");

return $router;
