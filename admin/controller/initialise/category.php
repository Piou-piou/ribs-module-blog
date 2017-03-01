<?php
	$category = new \modules\blog\admin\controller\AdminCategory();
	$_SESSION['category_name'] = $category->getNameCategoryUrl();
	
	$arr = \modules\blog\app\controller\Blog::getValues();