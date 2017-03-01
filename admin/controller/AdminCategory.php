<?php
	namespace modules\blog\admin\controller;
	
	
	use core\App;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;
	use modules\blog\app\controller\Blog;
	
	class AdminCategory {
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param $name
		 * @param null $id
		 * @return bool
		 * test if a category exist
		 */
		private function getTestCategoryExist($name, $id=null) {
			$dbc = App::getDb();
			
			if ($id === null) {
				$query = $dbc->select()->from("_blog_category")->where("category", "=", $name)->get();
			}
			else {
				$query = $dbc->select()->from("_blog_category")
					->where("category", "=", $name, "AND")->where("ID_category", "!=", $id)->get();
			}
			
			if (count($query) > 0) {
				foreach ($query as $obj) {
					
					return $obj->ID_category;
				}
			}
			
			return false;
		}
		
		/**
		 * function t get name of a category with it url
		 */
		public function getNameCategoryUrl() {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("_blog_category")->where("url_category", "=", Blog::$router_parameter)->get();
			
			if (count($query) == 1) {
				foreach ($query as $obj) {
					Blog::setValues([
						"category_name" => $obj->category,
						"id_category" => $obj->ID_category
					]);
				}
				
				return $obj->category;
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $name
		 * @return bool
		 * function to add a category
		 */
		public function setAddCategory($name) {
			$dbc = App::getDb();
			
			if ($this->getTestCategoryExist($name) !== false) {
				FlashMessage::setFlash("Cette catégorie existe déjà, merci de changer de nom");
				return false;
			}
			
			$dbc->insert("category", $name)->insert("url_category", ChaineCaractere::setUrl($name))->into("_blog_category")->set();
			FlashMessage::setFlash("Votre catégorie a été correctement ajoutée", "success");
			return true;
		}
		
		/**
		 * @param $name
		 * @param $id
		 * @return bool
		 * function to edit the name of a category
		 */
		public function setEditCategory($name, $id) {
			$dbc = App::getDb();
			
			if ($this->getTestCategoryExist($name, $id) !== false) {
				FlashMessage::setFlash("Cette catégorie existe déjà, merci de changer de nom");
				return false;
			}
			
			$dbc->update("category", $name)->update("url_category", ChaineCaractere::setUrl($name))
				->from("_blog_category")->where("ID_category", "=", $id)->set();
			
			FlashMessage::setFlash("Votre catégorie a été correctement ajoutée", "success");
			return true;
		}
		
		/**
		 * @param $categories
		 * @param $id_article
		 * add list of categories to an article
		 */
		public function setCategoriesArticle($categories, $id_article) {
			$dbc = App::getDb();
			
			$count = count($categories);
			if ((is_array($categories)) && ($count > 0)) {
				for ($i=0 ; $i<$count ; $i++) {
					if ($this->getTestCategoryExist($categories[$i]) != false) {
						$dbc->insert("ID_category", $this->getTestCategoryExist($categories[$i]))->insert("ID_article", $id_article)->into("_blog_article_category")->set();
					}
				}
			}
		}
		
		/**
		 * @param $categories
		 * @param $id_article
		 * function to update catgories, in first step delete all categories and reinsert it after
		 */
		public function setUpdateCategoriesArticle($categories, $id_article) {
			$dbc = App::getDb();
			
			$dbc->delete()->from("_blog_article_category")->where("ID_article", "=", $id_article)->del();
			
			$this->setCategoriesArticle($categories, $id_article);
		}
		
		/**
		 * @param $id_category
		 * function that can delete an category and all article related to it
		 */
		public function setDeleteCategory($id_category) {
			$dbc = App::getDb();
			
			$dbc->delete()->from("_blog_category")->where("ID_category", "=", $id_category)->del();
			$dbc->delete()->from("_blog_article_category")->where("ID_category", "=", $id_category)->del();
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}