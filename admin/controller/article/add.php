<?php
	$article = new \modules\blog\admin\controller\AdminArticle();
	
	if ($article->setAddArticle($_POST['title'], $_POST['categories'], $_POST['article'], $_POST['state']) == false) {
		$_SESSION['title'] = $_POST['title'];
		$_SESSION['article'] = $_POST['article'];
		
		header("location:".ADMWEBROOT."modules/blog/add-article");
	}
	else {
		unset($_SESSION['title']);
		unset($_SESSION['article']);
		
		\core\HTML\flashmessage\FlashMessage::setFlash("Votre article a été correctement ajouté", "success");
		
		header("location:".ADMWEBROOT."modules/blog");
	}
	