<?php
	$article = new \modules\blog\app\controller\Article();
	$article->getArticle();
	
	$category = new \modules\blog\app\controller\Category();
	$category->getCategoryArticle();
	
	$arr = \modules\blog\app\controller\Blog::getValues();
	
	\core\App::setTitle(" ".$arr["blog"]["article"]["title"]);
	\core\App::setDescription("". $arr["blog"]["article"]["title"]);