DROP TABLE IF EXISTS `ss_users`;
CREATE TABLE IF NOT EXISTS `ss_users` (
  `userId` int(6) NOT NULL AUTO_INCREMENT,
  `userName` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revoked` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
