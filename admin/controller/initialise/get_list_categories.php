<?php
	$categories = new \modules\blog\app\controller\Category();
	
	\modules\blog\admin\controller\AdminBlog::getListSate();
	
	$arr = \modules\blog\app\controller\Blog::getValues();