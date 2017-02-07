<?php
	$blog = new \modules\blog\app\controller\Article();
	$blog->getArticle();
	
	$arr = \core\App::getValues();