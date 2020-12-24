--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1, 'dirk', SHA1('mylilsecret'), 'Dirk', 'Merkel', 1, 0, NOW(), NOW());
UNLOCK TABLES;