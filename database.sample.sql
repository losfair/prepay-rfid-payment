SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `nfc_payment` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `nfc_payment`;

CREATE TABLE IF NOT EXISTS `terminals` (
`terminal_id` int(4) unsigned NOT NULL,
  `terminal_hardwareidentifier` varchar(64) NOT NULL,
  `terminal_name` varchar(45) DEFAULT NULL,
  `terminal_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `terminal_amount` float NOT NULL DEFAULT '0',
  `terminal_message` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `transaction_log` (
`transaction_id` int(16) unsigned zerofill NOT NULL,
  `transaction_user_id` int(8) unsigned zerofill DEFAULT NULL,
  `transaction_initializedby_user_id` int(8) unsigned zerofill DEFAULT NULL,
  `transaction_amount` float DEFAULT NULL,
  `transaction_datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_terminal_id` int(4) unsigned zerofill DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(8) unsigned NOT NULL,
  `user_name` varchar(45) DEFAULT NULL,
  `user_type` varchar(45) DEFAULT NULL,
  `card_id` varchar(16) DEFAULT NULL,
  `credit_balance` float DEFAULT NULL,
  `admin_privilege` int(1) DEFAULT '0',
  `admin_login` varchar(45) DEFAULT NULL,
  `admin_hashedpassword` varchar(256) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


ALTER TABLE `terminals`
 ADD PRIMARY KEY (`terminal_id`);

ALTER TABLE `transaction_log`
 ADD PRIMARY KEY (`transaction_id`), ADD KEY `transaction_terminal_id_idx` (`transaction_terminal_id`), ADD KEY `transaction_initializedby_user_id_idx` (`transaction_initializedby_user_id`), ADD KEY `transaction_user_id_ibfk_idx` (`transaction_user_id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`), ADD UNIQUE KEY `card_id_UNIQUE` (`card_id`);


ALTER TABLE `terminals`
MODIFY `terminal_id` int(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
ALTER TABLE `transaction_log`
MODIFY `transaction_id` int(16) unsigned zerofill NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
ALTER TABLE `users`
MODIFY `user_id` int(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;

ALTER TABLE `transaction_log`
ADD CONSTRAINT `transaction_initializedby_user_id_ibfk` FOREIGN KEY (`transaction_initializedby_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `transaction_terminal_id_idx` FOREIGN KEY (`transaction_terminal_id`) REFERENCES `terminals` (`terminal_id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `transaction_user_id_ibfk` FOREIGN KEY (`transaction_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
