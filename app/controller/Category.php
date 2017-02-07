<?php
	namespace modules\blog\app\controller;
	
	
	use core\App;
	
	class Category {
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * get all categories of an article
		 */
		public function getCategoryArticle() {
			$dbc = App::getDb();
			
			$query = $dbc->select()
				->from("_blog_article")
				->from("_blog_category")
				->from("_blog_article_category")
				->where("_blog_article.ID_article", "=", Blog::$parametre_router, "OR")
				->where("_blog_article.url", "=", Blog::$parametre_router, "AND")
				->where("_blog_article_category.ID_article", "=", "_blog_article.ID_article", "AND", true)
				->where("_blog_article_category.ID_category", "=", "_blog_category.ID_category", "", true)
				->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$categories = [];
				foreach ($query as $obj) {
					$categories = [
						"id_category" => $obj->ID_category,
						"category" => $obj->category
					];
				}
				
				App::setValues(["categories" => $categories]);
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}