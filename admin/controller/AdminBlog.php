<?php
	namespace modules\blog\admin\controller;
	
	
	use core\App;
	use modules\blog\app\controller\Blog;
	
	class AdminBlog {
		private static $admin_category;
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public static function getAdminCategory() {
			if (self::$admin_category == null) {
				self::$admin_category = new AdminCategory();
			}
			
			return self::$admin_category;
		}
		
		public static function getListSate() {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("_blog_state")->get();
			
			$state = [];
			foreach ($query as $obj) {
				$state[] = [
					"id_state" => $obj->ID_state,
					"state" => $obj->state
				];
			}
			
			Blog::setValues(["list_state" => $state]);
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}