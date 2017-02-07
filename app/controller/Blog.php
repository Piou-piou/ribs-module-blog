<?php
	namespace modules\blog\app\controller;
	
	
	use core\App;
	
	class Blog {
		private static $force_login_comment;
		private static $article_index;
		private static $validate_comment;
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public static function getConfiguration() {
			if (self::$force_login_comment == null) {
				$dbc = App::getDb();
				
				$query = $dbc->select()->from("_blog_configuration")->where("ID_configuration", "=", 1)->get();
				
				foreach ($query as $obj) {
					self::$force_login_comment = $obj->force_login_comment;
					self::$article_index = $obj->article_index;
					self::$validate_comment = $obj->validate_comment;
				}
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}