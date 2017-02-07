<?php
	$blog = new \modules\blog\app\controller\Article();
	$blog->getLastArticle();
	
	$arr = \core\App::getValues();
	
	echo("<pre>");
	print_r($arr);
	echo("</pre>");
