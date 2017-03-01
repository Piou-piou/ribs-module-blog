<?php
	$category = new \modules\blog\admin\controller\AdminCategory();
	
	if ($category->setEditCategory($_POST['category'], $_POST['id_category']) == false) {
		$_SESSION['category_name'] = $_POST['category'];
		
		\modules\blog\app\controller\Blog::setValues(["category_name" => $obj->category]);
		
		header("location:".ADMWEBROOT."modules/blog/edit-category/".\core\functions\ChaineCaractere::setUrl($_POST['old_category']));
	}
	else {
		unset($_SESSION['category_name']);
		
		header("location:".ADMWEBROOT."modules/blog/list-categories");
	}
	