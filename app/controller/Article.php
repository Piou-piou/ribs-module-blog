<?php
	namespace modules\blog\app\controller;
	
	
	use core\App;
	
	class Article {
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * this function get last articles
		 */
		public function getLastArticle() {
			$dbc = App::getDb();
			$nb_article = Blog::getArticleIndex();
			
			$query = $dbc->select()->from("_blog_article")->limit(0,$nb_article)->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$articles = [];
				
				foreach ($query as $obj) {
					$articles[] = [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"article" => $obj->article,
						"publication_date" => $obj->publication_date,
						"categories" => Blog::getCategory()->getCategoryArticle($obj->url)
					];
				}
				
				Blog::setValues(["articles" => $articles]);
			}
		}
		
		public function getArticle() {
			$dbc = App::getDb();
			$param = Blog::$parametre_router;
			
			$query = $dbc->select()->from("_blog_article")
				->where("ID_article", "=", $param, "OR")
				->where("url", "=", $param)
				->get();
			
			if ((is_array($query)) && (count($query) == 1)) {
				foreach ($query as $obj) {
					Blog::setValues(["article" => [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"article" => $obj->article,
						"publication_date" => $obj->publication_date,
						"categories" => Blog::getCategory()->getCategoryArticle()
					]]);
				}
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}