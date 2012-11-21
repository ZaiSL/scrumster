<?php

class routerHelper {

	private static $url;
	
	/**
	 * Помошник генерации относительных ссылок
	 * 
	 * @static
	 * @param $route_name
	 * @param array $params
	 * @return string
	 */
	public static function href( $route_name, $params = array() ){

		/**
		 * @todo проверить оптимальность решения по расходу памяти и скорости
		 */
		if( self::$url===NULL ){
			self::$url = \Phalcon\DI::getDefault()->get('url', array());
		}
		
		return  self::$url->get(array("for" => $route_name) + $params);
	}

	/**
	 * Получение абсолютной (полной) ссылки на объект
	 * 
	 * @param $route_name
	 * @param array $params
	 * @return string
	 */
	public static function href_absolute( $route_name, $params = array() ){

		if( self::$url===NULL ){
			self::$url = \Phalcon\DI::getDefault()->get('url', array());
		}
		
		return self::$url->getBaseUri() . self::href($route_name, $params);
	}
	
}
