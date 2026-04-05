-- Database: utilisateurs
-- ------------------------------------------------------

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Table USERS (Mot de passe sécurisé par défaut)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `pseudo`, `nom`, `prenom`, `motDePasse`, `email`, `token`) VALUES 
(2, 'Ethan', 'Darnault', 'Ethan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ethandrnlt@icloud.com', 'f3a60671a399cd45d370fa8f87071216cf43b173e874bfbee9dd99a402ecb71e');

-- 2. Table REALISATEURS
DROP TABLE IF EXISTS `realisateurs`;
CREATE TABLE `realisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `realisateurs` (`id`, `name`) VALUES 
(1,'Damien Chazelle'),(2,'David Fincher'),(3,'Roman Polanski'),(4,'Olivier Nakache & Éric Toledano'),
(5,'Gus Van Sant'),(6,'Frank Darabont'),(7,'John McTiernan'),(8,'Christopher Nolan'),
(9,'Francis Ford Coppola'),(10,'Steven Spielberg'),(11,'Ridley Scott'),(12,'Chad Stahelski'),
(13,'The Wachowskis'),(14,'James Cameron'),(15,'David Leitch'),(16,'Kathryn Bigelow'),
(17,'Edgar Wright'),(18,'Tony Scott');

-- 3. Table FILMS
DROP TABLE IF EXISTS `films`;
CREATE TABLE `films` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `realisateur_id` int DEFAULT NULL,
  `sortie` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_realisateur` FOREIGN KEY (`realisateur_id`) REFERENCES `realisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `films` (`id`, `description`, `titre`, `prix`, `image`, `realisateur_id`, `sortie`) VALUES 
(1,'Un jeune batteur de jazz...','Whiplash',9.00,'whisplash.webp',1,2014),
(2,'Deux inspecteurs de police...','Seven',8.00,'seven.jpg',2,1995),
(8,'Alors que la Terre se meurt...','Interstellar',12.00,'interstellar.jpg',8,2014),
(11,'Batman affronte le Joker...','The Dark Knight',11.00,'dark_knight.jpg',8,2008),
(15,'Un Marine paraplégique...','Avatar',12.00,'avatar.jpg',14,2009),
(20,'Un commando de forces spéciales...','Predator',7.00,'predator.jpg',7,1987);
-- (Ajoute les autres films ici sur le même modèle)

-- 4. Table ACHATS (Liée à l'utilisateur ET au film)
DROP TABLE IF EXISTS `achats`;
CREATE TABLE `achats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `film_id` int NOT NULL,
  `date_achat` datetime DEFAULT CURRENT_TIMESTAMP,
  `prix_paye` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_achat` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_film_achat` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `achats` (`user_id`, `film_id`, `prix_paye`) VALUES (2, 2, 8.00), (2, 8, 12.00);

-- 5. Table ACTEURS
DROP TABLE IF EXISTS `acteurs`;
CREATE TABLE `acteurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `acteurs` (`id`, `name`) VALUES (1,'Miles Teller'),(2,'J.K. Simmons'),(3,'Brad Pitt'),(19,'Keanu Reeves'),(23,'Arnold Schwarzenegger');

-- 6. Table de liaison FILMS / ACTEURS
DROP TABLE IF EXISTS `film_acteurs`;
CREATE TABLE `film_acteurs` (
  `film_id` int NOT NULL,
  `acteur_id` int NOT NULL,
  PRIMARY KEY (`film_id`, `acteur_id`),
  CONSTRAINT `fk_fa_film` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`),
  CONSTRAINT `fk_fa_acteur` FOREIGN KEY (`acteur_id`) REFERENCES `acteurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `film_acteurs` (`film_id`, `acteur_id`) VALUES (1,1),(1,2),(2,3),(20,23);

SET FOREIGN_KEY_CHECKS = 1;