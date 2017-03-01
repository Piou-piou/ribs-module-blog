<?php
	namespace modules\blog\admin\controller;
	
	
	use core\App;
	
	class AdminCategory {
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param $name
		 * @return bool
		 * test if a category exist
		 */
		private function getTestCategoryExist($name) {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("_blog_category")->where("category", "=", $name)->get();
			
			if (count($query) > 0) {
				foreach ($query as $obj) {
					
					return $obj->ID_category;
				}
			}
			
			return false;
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
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