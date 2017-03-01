<?php
	
	$category = new \modules\blog\admin\controller\AdminCategory();
	
	$category->setDeleteCategory($_GET['id_category']);
	
	header("location:".ADMWEBROOT."modules/blog/list-categories");