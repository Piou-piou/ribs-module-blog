<?php
	
	$article = new \modules\blog\app\controller\Article();
	$article->getCategoryArticle();
	
	$category = new \modules\blog\app\controller\Category();
	
	$arr = \modules\blog\app\controller\Blog::getValues();
	
	\core\App::setTitle("Blog module list articles of category ".$category->getNamemCategorieUrl());
	\core\App::setDescription("Description of the blog module ". $category->getNamemCategorieUrl());