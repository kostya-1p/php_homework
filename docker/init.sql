CREATE DATABASE IF NOT EXISTS expenses;
USE expenses;
CREATE TABLE IF NOT EXISTS `transactions` (
                                `id` int NOT NULL AUTO_INCREMENT,
                                `date` varchar(45) NOT NULL,
                                `check_num` int DEFAULT NULL,
                                `description` varchar(100) DEFAULT NULL,
                                `amount` double NOT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;