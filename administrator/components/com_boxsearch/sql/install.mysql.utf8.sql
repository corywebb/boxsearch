CREATE TABLE `#__boxsearch_keys` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


INSERT INTO `#__boxsearch_keys` (`id`, `name`, `value`, `date`) VALUES ('1', 'access_token', '', '2013-01-01 00:00:00'), ('2', 'refresh_token', '', '2013-01-01 00:00:00');

CREATE TABLE `#__boxsearch_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;