<?php

class PagesController extends ControllerBase
{
	/**
	 * Статичные страницы
	 * 
	 */
	public function pagesAction(){
		
		$pageSlug = $this->dispatcher->getParam('slug');
		
		require_once __dir__.'/../../app/config/pages.php';

		if (isset($pages[$pageSlug])) {
			
			$this->view->pick("pages/$pageSlug");
			
			$this
				->setTitle( $pages[$pageSlug]['title'] )
				->setH1( $pages[$pageSlug]['title'] )
				->setDescription( $pages[$pageSlug]['meta'] );

		} else {
			
			$this->notFoundAction();
		}
		
	}

	public function page404Action(){
		
		$this->notFoundAction();
	}
	
}

