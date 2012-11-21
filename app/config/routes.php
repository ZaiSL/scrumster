<?php

$router = new Phalcon\Mvc\Router( false );

$router->setDefaults(array(
    'controller' => 'index',
    'action' => 'index',
	'page'=>0
));

/* тестовая площадка */
$router->addGet("/sandbox/", array(
	'controller'    => 'sandbox',
	'action'        => 'index',
))->setName("sandbox");

return $router;
