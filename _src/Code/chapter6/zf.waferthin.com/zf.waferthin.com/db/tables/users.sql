--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT 'User email address for authentication & notification purposes',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT 'Password for authentication purposes',
  `first_name` varchar(30) NOT NULL DEFAULT '' COMMENT 'User first name',
  `last_name` varchar(30) NOT NULL DEFAULT '' COMMENT 'User last name',
  `active` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT 'Boolean active flag',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Boolean deleted flag (logical delete)',
  `created_date` datetime NOT NULL COMMENT 'Creation / sign up date',
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time on which the record was last updated',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;