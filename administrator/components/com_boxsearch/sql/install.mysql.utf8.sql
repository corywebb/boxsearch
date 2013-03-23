CREATE TABLE `#__boxsearch_keys` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


INSERT INTO `#__boxsearch_keys` (`id`, `name`, `value`, `date`) VALUES ('1', 'access_token', '', '2013-01-01 00:00:00'), ('2', 'refresh_token', '', '2013-01-01 00:00:00');