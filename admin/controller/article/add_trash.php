<?php
	$article = new \modules\blog\admin\controller\AdminArticle();
	
	$article->setTrashArticle($_GET['id_article']);
	
	header("location:".ADMWEBROOT."modules/blog");