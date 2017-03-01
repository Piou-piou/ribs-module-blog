<?php
	namespace modules\blog\admin\controller;
	
	
	use core\App;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;
	use Intervention\Image\ImageManager;
	use modules\blog\app\controller\Article;
	use modules\blog\app\controller\Blog;
	
	class AdminArticle extends Article {
		private $error_title;
		private $error_article;
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param $title
		 * @return bool
		 * function that verify if title of the article is ok
		 */
		private function getTestTitle($title, $id_article=null) {
			$dbc = App::getDb();
			
			if (strlen($title) < 5){
				$this->error_title = "votre titre doit être supérieur à 4 caractères";
				return false;
			}
			
			if (strlen($title) > 20) {
				$this->error_title = "votre titre ne doit pas eccéder 20 caractères";
				return false;
			}
			
			if ($id_article == null) {
				$query = $dbc->select()->from("_blog_article")->where("title", "=", $title)->get();
			}
			else {
				$query = $dbc->select()->from("_blog_article")
					->where("title", "=", $title, "AND")->where("ID_article", "!=", $id_article)->get();
			}
			
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
		
		/**
		 * @param $id_article
		 * @return bool
		 * test if an article exist in bdd
		 */
		private function getTestArticleExist($id_article) {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("_blog_article")->where("ID_article", "=", $id_article)->get();
			
			if (count($query) == 0) {
				return false;
			}
			
			return true;
		}
		
		/**
		 * @param $id_article
		 * @return mixed
		 * function that get url of an article
		 */
		private function getUrl($id_article) {
			$dbc = App::getDb();
			
			$query = $dbc->select("url")->from("_blog_article")->where("ID_article", "=", $id_article)->get();
			
			foreach ($query as $obj) {
				return $obj->url;
			}
		}
		
		/**
		 * this function get last articles
		 */
		public function getAllArticle($id_state = null) {
			$dbc = App::getDb();
			
			if ($id_state === null) {
				$query = $dbc->select()
					->from("_blog_article")
					->from("_blog_state")
					->from("identite")
					->where("_blog_article.ID_identite", "=", "identite.ID_identite", "AND", true)
					->where("_blog_article.ID_state", "=", "_blog_state.ID_state", "", true)
					->orderBy("publication_date", "DESC")
					->get();
			}
			else {
				$query = $dbc->select()
					->from("_blog_article")
					->from("_blog_state")
					->from("identite")
					->where("_blog_article.ID_state", "=", $id_state, "AND")
					->where("_blog_article.ID_identite", "=", "identite.ID_identite", "AND", true)
					->where("_blog_article.ID_state", "=", "_blog_state.ID_state", "", true)
					->orderBy("publication_date", "DESC")
					->get();
			}
			
			if ((is_array($query)) && (count($query) > 0)) {
				$articles = [];
				
				foreach ($query as $obj) {
					$articles[] = [
						"id_article" => $obj->ID_article,
						"title" => $obj->title,
						"url" => $obj->url,
						"image" => $this->getImageArticle($obj->url),
						"article" => $obj->article,
						"id_state" => $obj->ID_state,
						"state" => $obj->state,
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
		/**
		 * @param $title
		 * function that add image to an article
		 */
		private function setImageArticle($title) {
			if (!empty($_FILES['image']['tmp_name'])) {
				$title_image = ChaineCaractere::setUrl($title);
				
				$name_image = ROOT."modules/blog/images/".$title_image.".png";
				
				$manager = new ImageManager();
				$image = $manager->make($_FILES['image']['tmp_name']);
				$image->crop(400, 400);
				$image->save($name_image);
			}
		}
		
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
			
			$this->setImageArticle($title);
			
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
		
		/**
		 * @param $title
		 * @param $categories
		 * @param $article
		 * @param $state
		 * @return bool
		 * function to edit an article and his categories
		 */
		public function setEditArticle($title, $categories, $article, $state, $id_article) {
			$dbc = App::getDb();
			
			if ($this->getTestTitle($title, $id_article) == false || $this->getTestArticle($article) == false) {
				FlashMessage::setFlash($this->error_title.$this->error_article);
				return false;
			}
			
			if ($this->getTestArticleExist($id_article) == false) {
				FlashMessage::setFlash("votre article n'existe pas");
				return false;
			}
			
			$dbc->update("title", $title)
				->update("url", ChaineCaractere::setUrl($title))
				->update("article", $article)
				->update("ID_identite", $_SESSION['idlogin'.CLEF_SITE])
				->update("ID_state", $state)
				->from("_blog_article")
				->where("ID_article", "=", $id_article)
				->set();
			
			AdminBlog::getAdminCategory()->setUpdateCategoriesArticle($categories, $id_article);
			return true;
		}
		
		/**
		 * @param $id_article
		 * function that is used to delete an article
		 */
		public function setTrashArticle($id_article) {
			$dbc = App::getDb();
			
			if ($this->getTestArticleExist($id_article) == true) {
				$dbc->update("ID_state", 4)->from("_blog_article")->where("ID_article", "=", $id_article)->set();
			}
			
			FlashMessage::setFlash("Votre message a bien été archivé", "success");
		}
		
		/**
		 * @param $id_article
		 * function that is used to delete an article
		 */
		public function setDeleteArticle($id_article) {
			$dbc = App::getDb();
			
			if ($this->getTestArticleExist($id_article) == true) {
				unlink(ROOT."modules/blog/images/".$this->getUrl($id_article).".png");
				
				$dbc->delete()->from("_blog_article")->where("ID_article", "=", $id_article)->del();
			}
			
			FlashMessage::setFlash("Votre message a bien été supprimé", "success");
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}