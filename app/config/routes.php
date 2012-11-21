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

//отдача всех ишью
$router->addGet('/api/issues/', array(
	'controller'    => 'api',
	'action'        => 'issueList',
))->setName("api_issue_list");
//добавление ишью
$router->addPost('/api/issues/', array(
	'controller'    => 'api',
	'action'        => 'issueAdd',
))->setName("api_issue_add");

//список юзеров
$router->addGet('/api/users/', array(
	'controller'    => 'api',
	'action'        => 'userList',
))->setName("api_user_list");
//добавление юзера
$router->addPost('/api/users/', array(
	'controller'    => 'api',
	'action'        => 'userAdd',
))->setName("api_user_add");

return $router;
