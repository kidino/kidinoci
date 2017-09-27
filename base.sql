-- --------------------------------------------------------
-- Host:                         local
-- Server version:               5.6.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for procedure kidinoci.alter_model_columns
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `alter_model_columns`(IN `tablename` VARCHAR(50))
BEGIN

SET @npfx_query = CONCAT("alter table ",tablename," add column `deleted_at` DATETIME NULL DEFAULT NULL, add column `created_at` DATETIME NULL DEFAULT NULL, add column `updated_at` DATETIME NULL DEFAULT NULL;");
-- prepared statement 1
PREPARE not_prefixed FROM @npfx_query;
EXECUTE not_prefixed;


END//
DELIMITER ;


-- Dumping structure for table kidinoci.app_settings
CREATE TABLE IF NOT EXISTS `app_settings` (
  `sett_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sett_name` varchar(50) DEFAULT NULL,
  `sett_value` text,
  PRIMARY KEY (`sett_id`),
  UNIQUE KEY `sett_name` (`sett_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Dumping data for table kidinoci.app_settings: ~11 rows (approximately)
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
INSERT INTO `app_settings` (`sett_id`, `sett_name`, `sett_value`) VALUES
	(1, 'application_name', 'Kidino CI'),
	(2, 'timezone', 'Asia/Kuala_Lumpur'),
	(3, 'email_from_email', 'kidinoci@gmail.com'),
	(4, 'email_from_name', 'Kidino CI'),
	(5, 'email_useragent', 'codeigniter'),
	(6, 'email_method', 'mail'),
	(7, 'smtp_port', ''),
	(8, 'smtp_host', ''),
	(9, 'smtp_username', ''),
	(10, 'smtp_password', ''),
	(11, 'smtp_connection', '');
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;


-- Dumping structure for table kidinoci.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kidinoci.ci_sessions: ~4 rows (approximately)
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('ahgoudhvjf841e5fmble92aajihen0qj', '127.0.0.1', 1506525121, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313530363532353132313B757365725F69647C733A313A2231223B757365726E616D657C733A353A2261646D696E223B7374617475737C733A313A2231223B6163636573737C613A373A7B693A303B733A31343A2261646D696E5F70726F6A65637473223B693A313B733A31373A2261646D696E5F6465706172746D656E7473223B693A323B733A31363A2261646D696E5F61637469766974696573223B693A333B733A31383A2261646D696E5F6F7267616E69736174696F6E223B693A343B733A31313A2261646D696E5F7573657273223B693A353B733A31323A2261646D696E5F67726F757073223B693A363B733A31383A2261646D696E5F6170705F73657474696E6773223B7D69735F73757065727C733A313A2231223B),
	('nmbq64cloian8j431p3rutnnlp30gi7o', '127.0.0.1', 1506525831, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313530363532353833313B757365725F69647C733A313A2231223B757365726E616D657C733A353A2261646D696E223B7374617475737C733A313A2231223B6163636573737C613A373A7B693A303B733A31343A2261646D696E5F70726F6A65637473223B693A313B733A31373A2261646D696E5F6465706172746D656E7473223B693A323B733A31363A2261646D696E5F61637469766974696573223B693A333B733A31383A2261646D696E5F6F7267616E69736174696F6E223B693A343B733A31313A2261646D696E5F7573657273223B693A353B733A31323A2261646D696E5F67726F757073223B693A363B733A31383A2261646D696E5F6170705F73657474696E6773223B7D69735F73757065727C733A313A2231223B),
	('t2hrl7d3g27aad0ntuth98fniparrsc8', '127.0.0.1', 1506526316, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313530363532363331363B),
	('ia7du4simau98se00hu3euj1cdhclki2', '127.0.0.1', 1506526655, _binary 0x5F5F63695F6C6173745F726567656E65726174657C693A313530363532363535383B757365725F69647C733A313A2231223B757365726E616D657C733A353A2261646D696E223B7374617475737C733A313A2231223B6163636573737C613A373A7B693A303B733A31343A2261646D696E5F70726F6A65637473223B693A313B733A31373A2261646D696E5F6465706172746D656E7473223B693A323B733A31363A2261646D696E5F61637469766974696573223B693A333B733A31383A2261646D696E5F6F7267616E69736174696F6E223B693A343B733A31313A2261646D696E5F7573657273223B693A353B733A31323A2261646D696E5F67726F757073223B693A363B733A31383A2261646D696E5F6170705F73657474696E6773223B7D69735F73757065727C733A313A2231223B);
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;


-- Dumping structure for table kidinoci.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kidinoci.contacts: ~0 rows (approximately)
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;


-- Dumping structure for table kidinoci.login_attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table kidinoci.login_attempts: ~0 rows (approximately)
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;


-- Dumping structure for table kidinoci.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `fullname` varchar(255) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `is_super` tinyint(1) DEFAULT '0',
  `groups` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table kidinoci.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `activated`, `banned`, `ban_reason`, `new_password_key`, `is_super`, `groups`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '$P$BQUANaQWJ16E0bEap2KUZoGcyT1ws01', 'admin@myadmin.com', 'Most Powerful', 1, 0, NULL, NULL, 1, '1', NULL, NULL, NULL, '127.0.0.1', '2017-09-27 23:37:31', '0000-00-00 00:00:00', '2017-09-27 23:37:31', NULL, '2017-09-23 23:00:05', '2017-09-24 03:08:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table kidinoci.user_access_types
CREATE TABLE IF NOT EXISTS `user_access_types` (
  `acctype_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`acctype_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table kidinoci.user_access_types: ~9 rows (approximately)
/*!40000 ALTER TABLE `user_access_types` DISABLE KEYS */;
INSERT INTO `user_access_types` (`acctype_id`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'admin_projects', NULL, '2017-09-27 22:59:43', NULL),
	(2, 'admin_departments', NULL, '2017-09-27 22:59:44', NULL),
	(3, 'admin_activities', NULL, '2017-09-27 22:59:45', NULL),
	(4, 'admin_organisation', NULL, '2017-09-27 22:59:46', NULL),
	(5, 'admin_users', NULL, '2017-09-27 22:59:47', NULL),
	(6, 'admin_groups', NULL, '2017-09-27 22:59:48', NULL),
	(7, 'admin_app_settings', NULL, '2017-09-27 22:59:49', NULL),
	(8, 'admin_group_access', NULL, '2017-09-27 22:59:51', NULL),
	(9, 'admin_access_types', NULL, '2017-09-27 22:59:52', NULL);
/*!40000 ALTER TABLE `user_access_types` ENABLE KEYS */;


-- Dumping structure for table kidinoci.user_autologin
CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table kidinoci.user_autologin: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_autologin` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_autologin` ENABLE KEYS */;


-- Dumping structure for table kidinoci.user_groups
CREATE TABLE IF NOT EXISTS `user_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table kidinoci.user_groups: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` (`group_id`, `name`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Mighty', 'mighty', NULL, NULL, NULL),
	(2, 'App Data Admin', 'appdata_admin', NULL, NULL, NULL);
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;


-- Dumping structure for table kidinoci.user_group_access
CREATE TABLE IF NOT EXISTS `user_group_access` (
  `group_access_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `acctype_id` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_access_id`),
  UNIQUE KEY `group_id_acctype_id` (`group_id`,`acctype_id`),
  KEY `group_id` (`group_id`),
  KEY `acctype_id` (`acctype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Dumping data for table kidinoci.user_group_access: ~11 rows (approximately)
/*!40000 ALTER TABLE `user_group_access` DISABLE KEYS */;
INSERT INTO `user_group_access` (`group_access_id`, `group_id`, `acctype_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(7, 1, 1, NULL, NULL, NULL),
	(8, 1, 2, NULL, NULL, NULL),
	(9, 1, 3, NULL, NULL, NULL),
	(10, 1, 4, NULL, NULL, NULL),
	(11, 1, 5, NULL, NULL, NULL),
	(12, 1, 6, NULL, NULL, NULL),
	(13, 1, 7, NULL, NULL, NULL),
	(14, 2, 1, NULL, NULL, NULL),
	(15, 2, 2, NULL, NULL, NULL),
	(16, 2, 3, NULL, NULL, NULL),
	(17, 2, 4, NULL, NULL, NULL);
/*!40000 ALTER TABLE `user_group_access` ENABLE KEYS */;


-- Dumping structure for table kidinoci.user_profiles
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table kidinoci.user_profiles: ~1 rows (approximately)
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`, `photo`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
