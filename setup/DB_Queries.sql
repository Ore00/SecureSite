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

DROP TABLE IF EXISTS `ss_profile`;
CREATE TABLE IF NOT EXISTS `ss_profile` (
  `profileId` int(6) NOT NULL AUTO_INCREMENT,
  `userId` int(6) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(20),
  PRIMARY KEY (`profileId`),
  FOREIGN KEY `userId` (`userId`)
  REFERENCES `ss_user`(`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
