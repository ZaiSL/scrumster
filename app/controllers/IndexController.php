<?php

class IndexController extends ControllerBase {

    public function indexAction() {

        $this->view->setVar('hello','Привет упыри!');
    }
    
	public function loginFormAction() {}
	
	public function loginAction() {
		
		$name = $this->request->getPost('login');
		$pass = $this->request->getPost('password');
		
		$user = Users::findFirst(array(
			'conditions' => 'username=:name:',
			'bind' => array(
				'name' => $name,
			)
		));
		
		if ($user !== false) {
			
			list($db_pass, $db_salt) = explode(':',$user->password);
			if (sha1($pass.$db_salt) == $db_pass) {

				//все хорошо
				$this->session->set('auth', array(
					'user' => $user
				));
				
				var_dump(111);die;
				
				return $this->dispatcher->forward(array(
						'controller' => 'index',
						'action' => 'index'
				));
			}
		}

		//пусть снова заполняет данные в форме
		return $this->dispatcher->forward(array(
				'controller' => 'index',
				'action' => 'loginForm'
		));
	}
}

