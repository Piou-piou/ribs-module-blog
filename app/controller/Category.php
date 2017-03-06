<?php
	namespace modules\blog\app\controller;
	
	
	use core\App;
	
	class Category {
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("_blog_category")->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$categories = [];
				
				foreach ($query as $obj) {
					$categories[] = [
						"id_category" => $obj->ID_category,
						"category" => $obj->category,
						"url_category" => $obj->url_category
					];
				}
				
				Blog::setValues(["categories_list" => $categories]);
			}
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * get all categories of an article
		 */
		public function getCategoryArticle($id_article = null) {
			$dbc = App::getDb();
			
			if ($id_article === null) {
				$id_article = Blog::$router_parameter;
			}
			
			$query = $dbc->select()
				->from("_blog_article")
				->from("_blog_category")
				->from("_blog_article_category")
				->where("_blog_article.ID_article", "=", $id_article, "OR")
				->where("_blog_article.url", "=", $id_article, "AND")
				->where("_blog_article_category.ID_article", "=", "_blog_article.ID_article", "AND", true)
				->where("_blog_article_category.ID_category", "=", "_blog_category.ID_category", "", true)
				->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$categories = [];
				foreach ($query as $obj) {
					$categories[] = [
						"id_category" => $obj->ID_category,
						"category" => $obj->category,
						"url_category" => $obj->url_category
					];
				}
				
				return $categories;
			}
		}
		
		public function getNamemCategorieUrl() {
			$dbc = App::getDb();
			$url_category = Blog::$router_parameter;
			
			$query = $dbc->select("category")->from("_blog_category")->where("url_category", "=", $url_category)->get();
			
			foreach ($query as $obj) {
				return $obj->category;
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}