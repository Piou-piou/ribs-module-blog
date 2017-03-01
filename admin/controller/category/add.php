<?php
	$category = new \modules\blog\admin\controller\AdminCategory();
	
	if ($category->setAddCategory($_POST['category']) == false) {
		$_SESSION['category'] = $_POST['category'];
		
		header("location:".ADMWEBROOT."modules/blog/add-category");
	}
	else {
		unset($_SESSION['category']);
		
		header("location:".ADMWEBROOT."modules/blog/list-categories");
	}
	