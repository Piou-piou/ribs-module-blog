<?php
	$blog = new \modules\blog\admin\controller\AdminArticle();
	$blog->getAllArticle($_GET['id_state']);
	
	$category = new \modules\blog\app\controller\Category();
	
	$arr = \modules\blog\app\controller\Blog::getValues();