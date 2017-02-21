<?php
	$blog = new \modules\blog\app\controller\Article();
	$blog->getLastArticle();
	
	$category = new \modules\blog\app\controller\Category();
	
	$arr = \modules\blog\app\controller\Blog::getValues();