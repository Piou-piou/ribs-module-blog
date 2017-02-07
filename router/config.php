<?php
	//For the root folder of the blog
	define("BLOGWEBROOT", str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."modules/blog/app/views/");
	
	//For the root folder of the blog -> for include and require
	define('BLOGROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."modules/blog/app/views/");