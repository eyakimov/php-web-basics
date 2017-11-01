/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `cars` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `cars`;

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` year(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` (`id`, `make`, `model`, `year`) VALUES
	(1, 'Audi', 'A4', '2004'),
	(6, 'Ford', 'Cortina', '2010'),
	(7, 'BMW', '116', '2012'),
	(8, 'Ford', '2007', '0000'),
	(9, 'Audi', 'A4', '2004'),
	(10, 'Audi', 'A4', '2004'),
	(11, 'Audi', 'A4', '2004'),
	(12, 'Audi', 'A4', '0000'),
	(13, 'Audi,', 'A4', '2004'),
	(14, 'Audi,', 'A4', '2004'),
	(15, 'Audi,', 'A4', '2004');
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `family_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `first_name`, `family_name`) VALUES
	(1, ' Ilia', ' Petrov'),
	(3, 'Stoian', 'Zachariev'),
	(4, ' Iliana', ' Petrova'),
	(5, 'Stoian', 'Zachariev'),
	(6, 'Ivan', 'Ivanov'),
	(7, 'Ivan', 'Ivanov'),
	(8, 'Ivan', 'Ivanov'),
	(9, 'Ivan', 'Ivanov'),
	(10, 'Ivan', 'Ivanov'),
	(11, 'Ivan', 'Ivanov'),
	(12, 'Ivan', 'Ivanov');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

CREATE TABLE `deal` (
	`date_of_deal` DATETIME NOT NULL,
	`amount` FLOAT NOT NULL,
	`make` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`model` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`year` YEAR NOT NULL,
	`first_name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`family_name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `get_full_name`(
	`first_name` VARCHAR(255),
	`family_name` VARCHAR(255)
) RETURNS varchar(512) CHARSET utf8
    NO SQL
BEGIN
	DECLARE full_name VARCHAR(512);
	SET full_name= CONCAT (first_name, ' ', family_name);
    RETURN full_name;
END//
DELIMITER ;

DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sales`(OUT `amount_total` FLOAT)
    NO SQL
BEGIN
	SELECT SUM(`amount`) INTO amount_total FROM sales;
END//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `car_id` int(10) unsigned DEFAULT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  KEY `costumer_id` (`customer_id`),
  CONSTRAINT `FK1_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  CONSTRAINT `FK2_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` (`id`, `car_id`, `customer_id`, `date_time`, `amount`) VALUES
	(1, 1, 1, '2017-10-24 19:39:38', 3800),
	(2, 6, 3, '2017-10-24 19:48:31', 10000),
	(3, 7, 4, '2017-10-24 00:00:00', 20),
	(4, 8, 5, '2017-10-24 20:16:44', 7600),
	(5, 9, 6, '2017-10-29 22:27:39', 7000),
	(6, 10, 7, '2017-10-29 22:28:56', 7000),
	(7, 11, 8, '2017-10-29 22:58:02', 7000),
	(8, 12, 9, '2017-10-30 00:16:16', 7000),
	(9, 13, 10, '2017-10-30 01:04:19', 7000),
	(10, 14, 11, '2017-10-30 01:29:24', 7000),
	(11, 15, 12, '2017-10-30 01:47:40', 7000);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `total_sales` BEFORE INSERT ON `sales` FOR EACH ROW SET @sum = @sum + NEW.amount//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

DROP TABLE IF EXISTS `deal`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `deal` AS SELECT sales.date_time AS date_of_deal, sales.amount, cars.make, cars.model, cars.year, customers.first_name, customers.family_name
FROM sales, cars, customers
WHERE sales.car_id=cars.id AND sales.customer_id=customers.id ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
