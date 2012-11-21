<?php

$router = new Phalcon\Mvc\Router( false );

$router->setDefaults(array(
    'controller' => 'index',
    'action' => 'index',
));

//урл для авторизации
$router->addPost("/login/", array(
	'controller'    => 'index',
	'action'        => 'login',
))->setName("login");

//отдача всех ишью
$router->addGet('/issues/', array(
        'controller'    => 'api',
        'action'        => 'issueList',
    ))->setName("api_issue_list");

//добавление ишью
$router->addPost('/issues/', array(
	'controller'    => 'api',
	'action'        => 'issueAdd',
))->setName("api_issue_Add");

//список юзеров
$router->addGet('/users/', array(
	'controller'    => 'api',
	'action'        => 'userList',
))->setName("api_user_list");

//добавление юзера
$router->addPost('/users/', array(
	'controller'    => 'api',
	'action'        => 'userAdd',
))->setName("api_user_add");

return $router;
