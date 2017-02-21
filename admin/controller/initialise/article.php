<?php
	$article = new \modules\blog\app\controller\Article();
	$article->getArticle();
	
	$category = new \modules\blog\app\controller\Category();
	$category->getCategoryArticle();
	
	$arr = \modules\blog\app\controller\Blog::getValues();
	
	echo("<pre>");
	print_r($arr);
	echo("</pre>");