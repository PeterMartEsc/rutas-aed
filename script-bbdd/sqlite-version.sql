DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `routes`;

CREATE TABLE `roles` (
  `id` INTEGER PRIMARY KEY, 
  `name` TEXT NOT NULL UNIQUE
);

CREATE TABLE `images` (
  `id` INTEGER PRIMARY KEY, 
  `image` BLOB,
  `type_image` TEXT
);

CREATE TABLE `users` (
  `id` INTEGER PRIMARY KEY,
  `name` TEXT NOT NULL,
  `surname` TEXT NOT NULL,
  `email` TEXT NOT NULL UNIQUE,
  `phone` TEXT NOT NULL,
  `password` TEXT NOT NULL,  
  `id_image` INTEGER,
  `id_role` INTEGER,
  FOREIGN KEY (`id_image`) REFERENCES `images` (`id`),
  FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`)
);

CREATE TABLE `routes` (
  `id` INTEGER PRIMARY KEY,  
  `title` TEXT UNIQUE,
  `location` TEXT NOT NULL,
  `distance` INTEGER,
  `date_route` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `difficulty` INTEGER,
  `pets_allowed` BOOLEAN DEFAULT FALSE,
  `vehicle_needed` BOOLEAN DEFAULT FALSE,
  `description` TEXT,  
  `user_id` INTEGER,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

INSERT INTO `roles` (`id`,`name`) VALUES (1, 'Admin'); 
INSERT INTO `roles` (`id`,`name`) VALUES (2, 'User');  
