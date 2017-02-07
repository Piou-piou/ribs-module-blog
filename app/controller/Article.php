<?php
	namespace modules\blog\app\controller;
	
	
	use core\App;
	
	class Article {
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getLastArticle() {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("_blog_article")->limit(0, 5)->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
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