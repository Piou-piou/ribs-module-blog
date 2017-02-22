<?php
	namespace modules\blog\admin\controller;
	
	
	use core\App;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;
	
	class AdminArticle {
		private $error_title;
		private $error_article;
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param $title
		 * @return bool
		 * function that verify if title of the article is ok
		 */
		private function getTestTitle($title) {
			$dbc = App::getDb();
			
			if (ChaineCaractere::testMinLenght($title, 4) == false) {
				$this->error_title = "votre titre doit être supérieur à 4 caractères";
				return false;
			}
			
			if (strlen($title) > 20) {
				$this->error_title = "votre titre ne doit pas eccéder 20 caractères";
				return false;
			}
			
			$query = $dbc->select()->from("_blog_article")->where("title", "=", $title)->get();
			
			if (count($query) > 0) {
				$this->error_title = "votre titre existe déjà merci d'en choisir un autre";
				return false;
			}
			
			return true;
		}
		
		/**
		 * @param $article
		 * @return bool
		 * function that verify if article is ok
		 */
		private function getTestArticle($article) {
			if (ChaineCaractere::testMinLenght($article, 10) == false) {
				$this->error_article = "votre article doit être supérieur à 10 caractères";
				return false;
			}
			
			return true;
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $title
		 * @param $categories
		 * @param $article
		 * @param $state
		 * @return bool
		 * function to add an article and his categories
		 */
		public function setAddArticle($title, $categories, $article, $state) {
			$dbc = App::getDb();
			
			if ($this->getTestTitle($title) == false || $this->getTestArticle($article) == false) {
				FlashMessage::setFlash($this->error_title.$this->error_article);
				return false;
			}
			
			$dbc->insert("title", $title)
				->insert("url", ChaineCaractere::setUrl($title))
				->insert("publication_date", date("Y-m-d H:i:s"))
				->insert("article", $article)
				->insert("ID_identite", $_SESSION['idlogin'.CLEF_SITE])
				->insert("ID_state", $state)
				->into("_blog_article")->set();
			
			$id_article = $dbc->lastInsertId();
			
			AdminBlog::getAdminCategory()->setCategoriesArticle($categories, $id_article);
			return true;
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}