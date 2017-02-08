<?php
	$blog = new \modules\blog\app\controller\Article();
	$blog->getLastArticle();
	
	$arr = \modules\blog\app\controller\Blog::getValues();