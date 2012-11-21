<?php

class IndexController extends ControllerBase {

	/**
	 * Главная страница приложения
	 */
    public function indexAction() {

		$user = $this->session->get('auth');
		$this->view->setVar('user',$user['user']);
    }
    
	/**
	 * Метод-заглушка для формы авторизации
	 */
	public function loginFormAction() {}
	
	/**
	 * Авторизация юзера
	 */
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

                $this->response->redirect('/');

			}
		}

		//пусть снова заполняет данные в форме
		return $this->dispatcher->forward(array(
				'controller' => 'index',
				'action' => 'loginForm'
		));
	}
}
