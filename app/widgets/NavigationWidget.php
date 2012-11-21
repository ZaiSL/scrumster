<?php
/**
 * Навигация сверху
 * User: km
 * Date: 24.09.12
 * Time: 18:06
 */


class NavigationWidget extends WidgetBase{

    private static $navElements = array(
        array(
            'title'         => 'Все письма',
            'route'         => 'letters_index',
	        'route_params'  => array(),
            'controller'    => 'letters',
	        'action'        => 'index',
            'class'         =>'top-nav-link top-nav-link-letters'
        ),
        array(
            'title'         => 'Написать письмо',
            'route'         => 'letter_add',
	        'route_params'  => array(),
            'controller'    => 'letters',
	        'action'        => 'new',
	        'class'         =>'top-nav-link top-nav-link-write'
        ),
        /*
        array(
            'title'         => 'Удалить письмо',
            'route'         => 'pages',
            'route_params'  => array('slug'=>'deleteletters'),
            'controller'    => 'pages',
            'action'        => 'pages',
            'class'         =>'top-nav-link top-nav-link-write'
        ),
	    array(
		    'title'         => 'В прессе',
		    'route'         => 'pages',
		    'route_params'  => array( 'slug'=>'media' ),
            'controller'    => 'pages',
		    'action'        => 'pages',
		    'class'         =>'top-nav-link top-nav-link-press'
	    ),*/
        array(
            'title'         => 'Персоны',
            'route'         => 'persons',
	        'route_params'  => array(),
            'controller'    => 'persons',
	        'action'        => 'index',
	        'class'         =>'top-nav-link top-nav-link-persons'
        ),

    );

    /**
     * @static
     * @param \Phalcon\Mvc\View $view
     */
    public static function render($view){

        $controllerName = $view->dispatcher->getControllerName();
        $actionName     = $view->dispatcher->getActionName();

        echo '<ul class="top-nav">';


	    $navElements = self::$navElements;
	    
	    // админам добавляем еще один пункт
	    if( usersHelper::is_admin() ){
		    $navElements = array_merge( $navElements , array( 
			    array(
			    'title'         => 'Модерирование',
			    'route'         => 'letter_moderate',
			    'route_params'  => array(),
			    'controller'    => 'letters',
			    'action'        => 'moderate',
			    'class'         =>'top-nav-link top-nav-link-write'
		    )));
	    }
	    
	    $elementsCount = count($navElements);
	    for ($i=0; $i< $elementsCount; $i++){
		    
            $element = $navElements[$i];
            $active = ($element['controller'] == $controllerName && $element['action']==$actionName);
            $link = routerHelper::href($element['route'], $element['route_params'] );

            echo '<li><a class="'.$element['class'].($active ? ' active':'').'" href="'.$link.'">'.$element['title'].'</a></li>';
        }

        echo '</ul>';
    }

}