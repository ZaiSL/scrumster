<?php

$router = new Phalcon\Mvc\Router( false );

$router->setDefaults(array(
    'controller' => 'index',
    'action' => 'index',
	'page'=>0
));

//урл для авторизации
$router->addPost("/login/", array(
	'controller'    => 'index',
	'action'        => 'login',
))->setName("login");

return $router;
