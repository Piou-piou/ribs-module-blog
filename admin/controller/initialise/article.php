<?php
	$article = new \modules\blog\app\controller\Article();
	$article->getArticle();
	
	$category = new \modules\blog\app\controller\Category();
	$category->getCategoryArticle();
	
	\modules\blog\admin\controller\AdminBlog::getListSate();
	
	$arr = \modules\blog\app\controller\Blog::getValues();
	
	echo("<pre>");
	print_r($arr);
	echo("</pre>");