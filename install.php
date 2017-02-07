<?php
	$requete = "
		DROP TABLE IF EXISTS _blog_article ;
		CREATE TABLE _blog_article (ID_article INT  AUTO_INCREMENT NOT NULL,
		title VARCHAR(50),
		url VARCHAR(255),
		article TEXT,
		publication_date DATETIME,
		ID_identite INT,
		ID_state INT NOT NULL,
		PRIMARY KEY (ID_article) ) ENGINE=InnoDB;
		
		DROP TABLE IF EXISTS _blog_state ;
		CREATE TABLE _blog_state (ID_state INT  AUTO_INCREMENT NOT NULL,
		state VARCHAR(50),
		PRIMARY KEY (ID_state) ) ENGINE=InnoDB;
		
		DROP TABLE IF EXISTS _blog_category ;
		CREATE TABLE _blog_category (ID_category INT  AUTO_INCREMENT NOT NULL,
		category VARCHAR(50),
		PRIMARY KEY (ID_category) ) ENGINE=InnoDB;
		
		DROP TABLE IF EXISTS _blog_configuration ;
		CREATE TABLE _blog_configuration (ID_configuration INT  AUTO_INCREMENT NOT NULL,
		force_login_comment INT(1),
		article_index INT,
		validate_comment INT(1),
		PRIMARY KEY (ID_configuration) ) ENGINE=InnoDB;
		
		DROP TABLE IF EXISTS _blog_article_category ;
		CREATE TABLE _blog_article_category (ID_article_category INT  AUTO_INCREMENT NOT NULL,
		ID_category INT,
		ID_article INT,
		PRIMARY KEY (ID_article_category) ) ENGINE=InnoDB;
		
		INSERT INTO _blog_configuration (ID_configuration, force_login_comment, article_index, validate_comment) VALUES (NULL, '0', '5', '0');
	
		INSERT INTO `_blog_state` (`ID_state`, `state`) VALUES (NULL, 'publish'), (NULL, 'draft'), (NULL, 'replay'), (NULL, 'trash');
	";