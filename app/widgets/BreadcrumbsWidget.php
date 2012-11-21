<?php
/**
 *
 * User: km
 * Date: 24.09.12
 * Time: 18:28
 */

class BreadcrumbsWidget extends WidgetBase {

    private static $_path = array();

	/**
	 * Признак активности виджета
	 * @var bool
	 */
	private static $enable = true;
	
    /**
     * добавить линк
     *
     * @static
     * @param $title
     * @param $link
     */
    public static function add($title, $link){

        self::$_path[] = array(
            'title' => $title,
            'link'  => $link
        );

    }

    /**
     * @static
     * @param $view
     */
    public static function render($view){

	    // проверяем активность виджета
	    if( self::$enable != true){
		    return;
	    }

        if ($n = count(self::$_path)){
	        
            echo '<div class="breadcrumbs">';
            for ($i=0; $i<$n-1; $i++){
                
	            $el =  self::$_path[$i];
                $active = $i == $n-2;

                echo '<a href="'.$el['link'].'">'.$el['title'].'</a>';

                if (!$active){
                    echo ' <span class="breadcrumb-separator">/</span>';
                }


            }
            echo '</div>';

        }

    }

	/**
	 * Активация виджета
	 * 
	 * @static
	 */
	public static function setEnable(){

		self::$enable = true;
	}

	/**
	 * Отключение вывода виджета
	 * 
	 * @static
	 */
	public static function setDisable(){

		self::$enable = false;
	}


}