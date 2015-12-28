-- Create syntax for TABLE 'users'
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role_id` int(11),
  `create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update` timestamp NOT NULL,
  `active` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO users VALUES (NULL,'Username 1','username1@myemail.com',SHA1('password'),'first name 1','last name 1',1,NULL,NULL, TRUE);
INSERT INTO users VALUES (NULL,'Username 2','username2@email.com',MD5('password'),'first name 2','last name 2',2,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 3','username3@email.com',SHA1('password'),'first name 3','last name 3',3,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 4','username4@myemail.com',MD5('password'),'first name 4','last name 4',4,NULL,NULL, TRUE);
INSERT INTO users VALUES (NULL,'Username 5','username5@email.com',SHA1('password'),'first name 5','last name 5',5,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 6','username6@email.com',MD5('password'),'first name 6','last name 6',6,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 7','username7@myemail.com',SHA1('password'),'first name 7','last name 7',4,NULL,NULL, TRUE);
INSERT INTO users VALUES (NULL,'Username 8','username8@email.com',MD5('password'),'first name 8','last name 8',4,NULL,NULL, FALSE);
INSERT INTO users VALUES (NULL,'Username 9','username9@myemail.com',SHA1('password'),'first name 9','last name 9',4,NULL,NULL, FALSE);


-- Create syntax for TABLE 'roles'
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  `create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update` timestamp NOT NULL,
  `active` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO roles VALUES (NULL,'Superadmin',NULL,NULL, TRUE);
INSERT INTO roles VALUES (NULL,'Admin',NULL,NULL, TRUE);
INSERT INTO roles VALUES (NULL,'Publisher',NULL,NULL, TRUE);
INSERT INTO roles VALUES (NULL,'User',NULL,NULL, TRUE);
INSERT INTO roles VALUES (NULL,'Tester',NULL,NULL, TRUE);
INSERT INTO roles VALUES (NULL,'Customer',NULL,NULL, TRUE);


-- Create syntax for TABLE 'posts'
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update` timestamp NOT NULL,
  `active` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO posts VALUES (NULL,'Title 1','title-1','Lorem Ipsum','Category 1','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 2','title-2','Lorem Ipsum','Category 2','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 3','title-3','Lorem Ipsum','Category 3','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 4','title-4','Lorem Ipsum','Category 4','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 5','title-5','Lorem Ipsum','Category 5','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 6','title-6','Lorem Ipsum','Category 6','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 7','title-7','Lorem Ipsum','Category 7','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 8','title-8','Lorem Ipsum','Category 8','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 9','title-9','Lorem Ipsum','Category 9','keyword 1 keyword 2','image',NULL,NULL,TRUE);
INSERT INTO posts VALUES (NULL,'Title 10','title-10','Lorem Ipsum','Category 10','keyword 1 keyword 2','image',NULL,NULL,TRUE);



