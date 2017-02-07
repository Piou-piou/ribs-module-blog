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
			
			$query = $dbc->select()->from("_blog_article")->limit(0, $nb_article)->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$articles = [];
				
				foreach ($query as $obj) {
					$articles[] = [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"article" => $obj->article,
						"publication_date" => $obj->publication_date
					];
				}
				
				App::setValues(["blog" => $articles]);
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}