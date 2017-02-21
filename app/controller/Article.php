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
			
			$query = $dbc->select()
				->from("_blog_article")
				->from("identite")
				->where("_blog_article.ID_identite", "=", "identite.ID_identite", "", true)
				->limit(0, $nb_article)->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$articles = [];
				
				foreach ($query as $obj) {
					$articles[] = [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"article" => $obj->article,
						"pseudo" => $obj->pseudo,
						"publication_date" => $obj->publication_date,
						"categories" => Blog::getCategory()->getCategoryArticle($obj->url)
					];
				}
				
				Blog::setValues(["articles" => $articles]);
			}
		}
		
		/**
		 * function that get one article
		 */
		public function getArticle() {
			$dbc = App::getDb();
			$param = Blog::$router_parameter;
			
			$query = $dbc->select()->from("_blog_article")->from("identite")
				->where("ID_article", "=", $param, "OR")
				->where("url", "=", $param, "AND")
				->where("_blog_article.ID_identite", "=", "identite.ID_identite", "", true)
				->get();
			
			if ((is_array($query)) && (count($query) == 1)) {
				foreach ($query as $obj) {
					Blog::setValues(["article" => [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"article" => $obj->article,
						"pseudo" => $obj->pseudo,
						"publication_date" => $obj->publication_date,
						"categories" => Blog::getCategory()->getCategoryArticle()
					]]);
				}
			}
		}
		
		public function getCategoryArticle() {
			$dbc = App::getDb();
			$category = Blog::$router_parameter;
			
			$query = $dbc->select()
				->from("_blog_article")
				->from("_blog_category")
				->from("_blog_article_category")
				->from("identite")
				->where("_blog_category.ID_category", "=", $category, "OR")
				->where("_blog_category.category", "=", $category, "AND")
				->where("_blog_article_category.ID_article", "=", "_blog_article.ID_article", "AND", true)
				->where("_blog_article_category.ID_category", "=", "_blog_category.ID_category", "AND", true)
				->where("_blog_article.ID_identite", "=", "identite.ID_identite", "", true)
				->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$articles = [];
				
				foreach ($query as $obj) {
					$articles[] = [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"article" => $obj->article,
						"pseudo" => $obj->pseudo,
						"publication_date" => $obj->publication_date,
						"categories" => Blog::getCategory()->getCategoryArticle($obj->url)
					];
				}
				
				Blog::setValues(["articles" => $articles]);
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}