<?php
	$blog = new \modules\blog\app\controller\Article();
	$blog->getLastArticle();
	
	$arr = \core\App::getValues();