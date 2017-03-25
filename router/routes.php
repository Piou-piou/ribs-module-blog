<?php
	$pages_blog = [
		"index",
		"article",
		"category"
	];
	
	if (\core\modules\GestionModule::getModuleActiver("blog")) {
		if (!in_array($this->page, $pages_blog)) {
			header("location:".WEBROOT."404");
		}
		
		if ($this->page == "index") {
			$this->controller = "blog/app/controller/initialise/index.php";
		}
		
		if ($this->page == "article") {
			\modules\blog\app\controller\Blog::$router_parameter = $this->parametre;
			$this->controller = "blog/app/controller/initialise/article.php";
		}
		
		if ($this->page == "category") {
			\modules\blog\app\controller\Blog::$router_parameter = $this->parametre;
			$this->controller = "blog/app/controller/initialise/category.php";
		}
	}
	else {
		header("location:".WEBROOT."404");
	}