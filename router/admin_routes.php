<?php
	$pages_blog = [
		"index",
		"add-article",
		"edit-article",
		"list-categories",
		"add-category",
		"edit-category"
	];
	
	if (\core\modules\GestionModule::getModuleActiver("blog")) {
		if (!in_array($this->page, $pages_blog)) {
			\core\HTML\flashmessage\FlashMessage::setFlash("Cette page n'existe pas ou plus");
			header("location:".ADMWEBROOT);
		}
		
		//for articles pages
		if ($this->page == "index") {
			$this->controller = "blog/admin/controller/initialise/index.php";
		}
		
		if ($this->page == "edit-article") {
			\modules\blog\app\controller\Blog::$router_parameter = $this->parametre;
			$this->controller = "blog/admin/controller/initialise/article.php";
		}
		
		if ($this->page == "add-article") {
			$this->controller = "blog/admin/controller/initialise/get_list_categories.php";
		}
		
		
		//for categories pages
		if ($this->page == "list-categories") {
			$this->controller = "blog/admin/controller/initialise/get_list_categories.php";
		}
		
		if ($this->page == "edit-category") {
			\modules\blog\app\controller\Blog::$router_parameter = $this->parametre;
			$this->controller = "blog/admin/controller/initialise/category.php";
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("L'accès à ce module n'est pas configurer ou ne fais pas partie de votre offre, contactez votre administrateur pour résoudre ce problème", "info");
		header("location:".ADMWEBROOT);
	}