-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for post_site
CREATE DATABASE IF NOT EXISTS `post_site` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `post_site`;

-- Dumping structure for table post_site.account
CREATE TABLE IF NOT EXISTS `account` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `username` varchar(20) NOT NULL COMMENT 'User name',
  `email` varchar(20) NOT NULL,
  `phone` int(11) NOT NULL DEFAULT 0,
  `password` varchar(20) NOT NULL COMMENT 'User password',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table post_site.account: ~1 rows (approximately)
INSERT INTO `account` (`ID`, `username`, `email`, `phone`, `password`) VALUES
	(1, 'ral', 'ral@', 0, 'a1'),
	(4, 'ral1', 'ral@1', 1, 'a2'),
	(5, 'ral2', 'ral@2', 2, 'a2');

-- Dumping structure for function post_site.check_user
DELIMITER //
CREATE FUNCTION `check_user`(`name` VARCHAR(50),
	`mail` VARCHAR(50),
	`number` INT
) RETURNS varchar(40) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN #pārbauda vai lietotājvārds, epasts un telefona nummurs nav jau saglabāts datubāzē
DECLARE username_result VARCHAR(30);
DECLARE email_result VARCHAR(30);
DECLARE number_result VARCHAR(30);
DECLARE result VARCHAR(30);

SET username_result = (SELECT if (EXISTS (SELECT username FROM account WHERE username = name), "username", "0"));
SET email_result = (SELECT if (EXISTS (SELECT email FROM account WHERE email = mail), "email", "0"));
SET number_result = (SELECT if (EXISTS (SELECT number FROM account WHERE number = phone), "phone", "0"));

SET result = CONCAT_WS(",",username_result,email_result,number_result);
RETURN (result);
END//
DELIMITER ;

-- Dumping structure for function post_site.create_account
DELIMITER //
CREATE FUNCTION `create_account`(`username` VARCHAR(50),
	`email` VARCHAR(50),
	`phone` INT,
	`password` VARCHAR(50)
) RETURNS varchar(60) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN #izveido lietotāja kontu, izmantojot lietotājvārdu, epastu, telefona numuru, paroli un check_user funkciju
DECLARE account_exists VARCHAR(60);

set account_exists = (SELECT check_user(username, email, phone));

if account_exists = "0,0,0" then
INSERT INTO account (username, email, phone, PASSWORD) VALUE (username, email, phone, PASSWORD);
RETURN("account created");
ELSE 
RETURN(account_exists);
END if;






END//
DELIMITER ;

-- Dumping structure for function post_site.login
DELIMITER //
CREATE FUNCTION `login`(`name` VARCHAR(50),
	`pass` VARCHAR(50)
) RETURNS varchar(40) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN
declare user VARCHAR(20);
DECLARE user_id INT(10);


if LOCATE("@", NAME) = 0 then SET user = "username"; #pārbauda vai ievadītie dati ir ēpasts vai lietottājvārds, meklējot @ simbolu
SET user_id = (select id from account where username = NAME);
ELSE SET user = "email"; 
SET user_id = (select id from account where email = NAME);
END if;

if user = "username" then 
if (SELECT password FROM account WHERE username = name) = pass then
if exists(SELECT account_id from user where account_id=user_id) then 
UPDATE user SET TIME = NOW();
else
INSERT INTO user (account_id, time) values (user_id, NOW());
END if;
RETURN("loged in successfully");
ELSE 
RETURN("incorrect password or username");
END if;

ELSEIF
(SELECT password FROM account WHERE email = name) = pass then
if exists(SELECT account_id from user where account_id=user_id) then 
UPDATE user SET TIME = NOW();
else
INSERT INTO user (account_id, time) values (user_id, NOW());
END if;
RETURN("loged in successfully");
ELSE
RETURN("incorrect password or email");
END if;



END//
DELIMITER ;

-- Dumping structure for table post_site.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `namespace` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table post_site.migrations: ~0 rows (approximately)

-- Dumping structure for table post_site.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table post_site.posts: ~3 rows (approximately)
INSERT INTO `posts` (`ID`, `title`, `category`, `body`, `image`, `created_at`, `updated_at`, `tags`) VALUES
	(8, '3', '3', '3', '[{"filename":"scunt_1756893687_4ddaad0bc9c0ac4eeb30.jpg","originalfilename":"scunt.jpg","filetitle":"scunt.jpg"},{"filename":"shriek_1756893687_79a85dd3a2d0b31c2367.jpg","originalfilename":"shriek.jpg","filetitle":"shriek.jpg"},{"filename":"super-dumb_1756893687_0b3c124e5a7ee860a4e4.jpg","originalfilename":"super dumb.jpg","filetitle":"super dumb.jpg"}]', '2025-09-03 07:01:27', NULL, '["s"]'),
	(9, '4', '4', '4', '[{"filename":"shriek_1756894429_c08ddb5a0fc784002126.jpg","originalfilename":"shriek.jpg","filetitle":"shriek.jpg"}]', '2025-09-03 07:13:49', NULL, '[""]'),
	(10, '5', '5', '5', '[{"filename":"america-hurricane_1758017265_80a54133b9b90d615387.png","originalfilename":"america-hurricane.png","filetitle":"america-hurricane.png"},{"filename":"scunt_1758017265_27a369aef4bbb6c104e0.jpg","originalfilename":"scunt.jpg","filetitle":"scunt.jpg"},{"filename":"shriek_1758017265_348b500833dfc7f001b5.jpg","originalfilename":"shriek.jpg","filetitle":"shriek.jpg"},{"filename":"super-dumb_1758017265_718202e6ba40ea91a17b.jpg","originalfilename":"super dumb.jpg","filetitle":"super dumb.jpg"},{"filename":"testicular_torsion_wizard_meme_banner_1758017265_678534f6e1c396bf77cc.jpg","originalfilename":"Testicular_Torsion_Wizard_meme_banner.jpg","filetitle":"Testicular_Torsion_Wizard_meme_banner.jpg"}]', '2025-09-16 07:07:45', NULL, '["fsafe"]');

-- Dumping structure for table post_site.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table post_site.projects: ~0 rows (approximately)

-- Dumping structure for function post_site.timeout
DELIMITER //
CREATE FUNCTION `timeout`(`user_id` INT
) RETURNS varchar(20) CHARSET utf8 COLLATE utf8_unicode_ci
    COMMENT 'maybe'
BEGIN


#when user logs in or refreshes, check the timeout time, if the time is past timeout time, log out, if the time is before
#timeout time, refresh the timout time
#select TIME FROM user WHERE account_id = user_id;
RETURN("fraewga");
END


#when user logs in or refreshes, check the timeout time, if the time is past timeout time, log out, if the time is before
#timeout time, refresh the timout time//
DELIMITER ;

-- Dumping structure for table post_site.user
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Login ID',
  `account_id` int(10) unsigned NOT NULL COMMENT 'User id',
  `time` datetime NOT NULL COMMENT 'Time to work',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table post_site.user: ~1 rows (approximately)
INSERT INTO `user` (`ID`, `account_id`, `time`) VALUES
	(11, 4, '2025-09-10 13:41:08'),
	(12, 1, '2025-09-10 13:41:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
