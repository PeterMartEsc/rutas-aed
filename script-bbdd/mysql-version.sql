DROP DATABASE IF EXISTS `routes`;

CREATE DATABASE `routes`;

USE `routes`;

DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `groups_users`;
DROP TABLE IF EXISTS `routes`;


CREATE TABLE `roles` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE `groups` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE `images` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `image` BLOB,
  `type_image` VARCHAR(50)
);

CREATE TABLE `users` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `surname` VARCHAR(40) NOT NULL,
  `email` VARCHAR(40) NOT NULL UNIQUE,
  `phone` VARCHAR(15) NOT NULL,
  `password` VARCHAR(30) NOT NULL,
  `id_image` INTEGER,
  `id_role` INTEGER,
  FOREIGN KEY (`id_image`) REFERENCES `images` (`id`),
  FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`)
);

CREATE TABLE `groups_users` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `id_group` INTEGER NOT NULL,
  `id_user` INTEGER NOT NULL,
  FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`),
  FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
);

CREATE TABLE `routes` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(30) UNIQUE,
  `location` VARCHAR(40) NOT NULL,
  `distance` INTEGER,
  `date_route` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `description` VARCHAR(200),
  `group_id` INTEGER,
  FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
);





