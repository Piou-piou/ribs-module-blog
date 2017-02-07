<?php
	$article = new \modules\blog\app\controller\Article();
	$article->getArticle();
	
	$category = new \modules\blog\app\controller\Category();
	$category->getCategoryArticle();
	
	$arr = \core\App::getValues();
	
	echo("<pre>");
	print_r($arr);
	echo("</pre>");