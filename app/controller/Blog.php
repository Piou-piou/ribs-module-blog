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
		/**
		 * this function load the configuration of the blog
		 */
		public static function getConfiguration() {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("_blog_configuration")->where("ID_configuration", "=", 1)->get();
			
			foreach ($query as $obj) {
				self::$force_login_comment = $obj->force_login_comment;
				self::$article_index = $obj->article_index;
				self::$validate_comment = $obj->validate_comment;
			}
		}
		
		/**
		 * @return mixed
		 * this function get force login comment, if return 1 the user must be connected to post a comment
		 * on the article
		 */
		public static function getForceLoginComment() {
			if (self::$force_login_comment == null) {
				self::getConfiguration();
			}
			
			return self::$force_login_comment;
		}
		
		/*
		 * funciton that return the max nuber of article that we will get on index page
		 */
		public static function getArticleIndex() {
			if (self::$article_index == null) {
				self::getConfiguration();
			}
			
			return self::$article_index;
		}
		
		/**
		 * @return mixed
		 * function return if a comment must be validate to be displayed on the website only if this function
		 * return 1
		 */
		public static function getValidateComment() {
			if (self::$validate_comment == null) {
				self::getConfiguration();
			}
			
			return self::$validate_comment;
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}