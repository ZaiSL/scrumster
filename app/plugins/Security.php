<?php
use \Phalcon\Events\Event;
use \Phalcon\Mvc\Dispatcher;

class Security extends Phalcon\Mvc\User\Plugin {

	public function __construct($di) {
        $this->_di = $di;
    }
	
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {

		//а есть ли уже объект юзера в сессии
        $auth = $this->_di->getShared('session')->get('auth');
		if (isset($auth['user']) && $auth['user']->id) {
			return true;
		}
		
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        if ($controller=='index' && (!in_array($action, array('loginForm', 'login')))) {
			
			$dispatcher->forward(array(
					'controller' => 'index',
					'action' => 'loginForm'
			));
			return false;
        }
    }
}
