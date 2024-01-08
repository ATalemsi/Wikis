CREATE DATABASE wikis;


CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int NOT NULL,
  `CategoryName` varchar(255) DEFAULT NULL,
  `Created_AdminID` int DEFAULT NULL,
  PRIMARY KEY (`CategoryID`),
  KEY `Created_AdminID` (`Created_AdminID`)
) ;



CREATE TABLE IF NOT EXISTS `tags` (
  `TagID` int NOT NULL,
  `TagName` varchar(255) DEFAULT NULL,
  `created_id` int DEFAULT NULL,
  PRIMARY KEY (`TagID`),
  KEY `created_id` (`created_id`)
) ;



CREATE TABLE IF NOT EXISTS `users` (
  `ID_User` int NOT NULL,
  `Firstname` varchar(255) DEFAULT NULL,
  `Lastname` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `PasswordHash` varchar(255) DEFAULT NULL,
  `UserRole` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_User`)
) ;



CREATE TABLE IF NOT EXISTS `wikis` (
  `WikiID` int NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` text,
  `CreationDate` datetime DEFAULT NULL,
  `LastModifiedDate` datetime DEFAULT NULL,
  `AuthorID` int DEFAULT NULL,
  `CategoryID` int DEFAULT NULL,
  PRIMARY KEY (`WikiID`),
  KEY `AuthorID` (`AuthorID`),
  KEY `CategoryID` (`CategoryID`)
) ;



CREATE TABLE IF NOT EXISTS `wikitags` (
  `WikiID` int DEFAULT NULL,
  `TagID` int DEFAULT NULL,
  KEY `WikiID` (`WikiID`),
  KEY `TagID` (`TagID`)
) ;

