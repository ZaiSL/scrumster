<?php

abstract class htmlTags extends \Phalcon\Tag{
	
	private static $meta = array(
		'title'=>'',
		'description'=>'Открытое письмо',
		'keywords'=>'',
		'h1'=>''
	);
	
	
	public static function setTitle( $title ){
		
		// иногда может быть flase
		if( $title != false ){
			
			$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
			self::$meta['title'] = $title;		
		}
	}

	public static function getTitle(  ){

		return self::$meta['title'];
	}

	public static function setDescription( $description ){

		if ( $description != false ){

			$description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
			self::$meta['description'] = $description;
		}		
	}

	public static function getDescription(  ){

		return self::$meta['description'];
	}

	public static function setKeywords( $keywords ){

		if( $keywords != false ){
			$keywords = htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8');
			self::$meta['keywords'] = $keywords;
		}
	}

	public static function getKeywords(  ){

		return self::$meta['keywords'];
	}

	public static function setH1( $h1 ){

		if( $h1 != false ){
			
			$h1 = htmlspecialchars($h1, ENT_QUOTES, 'UTF-8');
			self::$meta['h1'] = $h1;		
		}
	}

	public static function getH1(  ){

		return self::$meta['h1'];
	}


	
}