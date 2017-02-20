<?php
	$pages_blog = [
		"index",
		"article",
		"category"
	];
	
	if (\core\modules\GestionModule::getModuleActiver("blog")) {
		if (!in_array($this->page, $pages_blog)) {
			\core\HTML\flashmessage\FlashMessage::setFlash("Cette page n'existe pas ou plus");
			header("location:".ADMWEBROOT);
		}
		
		if ($this->page == "index") {
			$this->controller = "blog/admin/controller/initialise/index.php";
		}
		
		if ($this->page == "article") {
		}
		
		if ($this->page == "category") {
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("L'accès à ce module n'est pas configurer ou ne fais pas partie de votre offre, contactez votre administrateur pour résoudre ce problème", "info");
		header("location:".ADMWEBROOT);
	}