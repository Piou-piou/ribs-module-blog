<?php
	$article = new \modules\blog\admin\controller\AdminArticle();
	print_r($_POST);echo("dfg");
	$article->setAddArticle($_POST['title'], $_POST['categories'], $_POST['article'], $_POST['state']);