<?php
	namespace modules\blog\app\controller;
	
	
	use core\App;
	
	class Article {
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		protected function getImageArticle($url_article) {
			$url_image = ROOT."modules/blog/images/".$url_article.".png";
			
			if (file_exists($url_image)) {
				return WEBROOT."modules/blog/images/".$url_article.".png";;
			}
			else {
				return WEBROOT."modules/blog/images/fond-bloc.jpg";
			}
		}
		
		/**
		 * @param $date
		 * @return string
		 * function that return datein french format
		 */
		protected function getDateFr($date) {
			$mois = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre");
			
			$explode = explode("-", $date);
			$jour_d = $explode[2];
			$mois_d = $explode[1];
			$annee_d = $explode[0];
			
			return $jour_d." ".$mois[$mois_d - 1]." ".$annee_d;
		}
		
		private function getExtract($article) {
			$article = substr(strip_tags($article), 0, 150)."...";
			
			return $article;
		}
		
		/**
		 * this function get last articles
		 */
		public function getLastArticle() {
			$dbc = App::getDb();
			$nb_article = Blog::getArticleIndex();
			
			$query = $dbc->select()
				->from("_blog_article")
				->from("identite")
				->where("_blog_article.ID_state", "=", 1, "AND")
				->where("_blog_article.ID_identite", "=", "identite.ID_identite", "", true)
				->orderBy("publication_date", "DESC")
				->limit(0, $nb_article)->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$articles = [];
				
				foreach ($query as $obj) {
					$articles[] = [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"image" => $this->getImageArticle($obj->url),
						"article" => $this->getExtract($obj->article),
						"pseudo" => $obj->pseudo,
						"publication_date" => $this->getDateFr($obj->publication_date),
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
			
			$query = $dbc->select()->from("_blog_article")->from("identite")->from("_blog_state")
				->where("ID_article", "=", $param, "OR")
				->where("url", "=", $param, "AND")
				->where("_blog_article.ID_identite", "=", "identite.ID_identite", "AND", true)
				->where("_blog_article.ID_state", "=", "_blog_state.ID_state", "", true)
				->get();
			
			if ((is_array($query)) && (count($query) == 1)) {
				foreach ($query as $obj) {
					$this->getExtract($obj->article);
					
					Blog::setValues(["article" => [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"article" => $obj->article,
						"extract" => $this->getExtract($obj->article),
						"pseudo" => $obj->pseudo,
						"id_state" => $obj->ID_state,
						"state" => $obj->state,
						"publication_date" => $this->getDateFr($obj->publication_date),
						"categories" => Blog::getCategory()->getCategoryArticle()
					]]);
				}
			}
		}
		
		/**
		 * function that get all categories of an article
		 */
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
				->where("_blog_article.ID_state", "=", 1, "AND")
				->where("_blog_article_category.ID_article", "=", "_blog_article.ID_article", "AND", true)
				->where("_blog_article_category.ID_category", "=", "_blog_category.ID_category", "AND", true)
				->where("_blog_article.ID_identite", "=", "identite.ID_identite", "", true)
				->orderBy("publication_date", "DESC")
				->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				$articles = [];
				
				foreach ($query as $obj) {
					$articles[] = [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"image" => $this->getImageArticle($obj->url),
						"article" => $this->getExtract($obj->article),
						"pseudo" => $obj->pseudo,
						"publication_date" => $this->getDateFr($obj->publication_date),
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