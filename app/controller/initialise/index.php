<?php
	$blog = new \modules\blog\app\controller\Article();
	$blog->getLastArticle();
	
	$category = new \modules\blog\app\controller\Category();
	
	$arr = \modules\blog\app\controller\Blog::getValues();
	
	\core\App::setTitle("Blog module");
	\core\App::setDescription("Description of the blog module");