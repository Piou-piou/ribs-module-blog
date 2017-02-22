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
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}