<?php

class ControllerBase extends \Phalcon\Mvc\Controller
{

	/**
	 * Инициализация контроллера, выполняется всегда перед текущим действием Action
	 */
	public function initialize()
	{
		htmlTags::setTitle( 'ronl' );
	}
		

	/**
	 * Отображение 404 страницы
	 */
	public function notFoundAction()
	{

		$this->response->setStatusCode(404, "Not Found");

		$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
		$this->view->pick('system/notfound');
	}

	/**
	 * Установка параметра title страницы
	 *
	 * @param string $title
	 * @return ControllerBase
	 */
	protected function setTitle( $title ){

		htmlTags::setTitle( $title );
		return $this;
	}

	/**
	 * Установка мета-тега description
	 *
	 * @param string $description
	 * @return ControllerBase
	 */
	protected function setDescription( $description ){

		htmlTags::setDescription( $description );
		return $this;
	}

	/**
	 * Установка мета-тега keywords
	 *
	 * @param string $keywords
	 * @return ControllerBase
	 */
	protected function setKeywords( $keywords ){

		htmlTags::setDescription( $keywords );
		return $this;
	}

	/**
	 * Установка заголовка H1 страницы
	 *
	 * @param string $h1
	 * @return ControllerBase
	 */
	protected function setH1( $h1 ){

		htmlTags::setH1( $h1 );
		return $this;
	}
	
}