CREATE TABLE `pi_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `expire` int(11) NOT NULL,
  `randstr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
