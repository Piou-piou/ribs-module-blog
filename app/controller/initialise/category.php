<?php
	
	$article = new \modules\blog\app\controller\Article();
	$article->getCategoryArticle();
	
	$category = new \modules\blog\app\controller\Category();
	
	$arr = \modules\blog\app\controller\Blog::getValues();