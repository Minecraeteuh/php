-- MySQL dump 10.13  Distrib 8.4.8, for macos15 (arm64)
--
-- Host: 127.0.0.1    Database: movie
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `achats`
--

DROP TABLE IF EXISTS `achats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `achats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_achat` datetime NOT NULL,
  `prix_achat` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achats`
--

LOCK TABLES `achats` WRITE;
/*!40000 ALTER TABLE `achats` DISABLE KEYS */;
INSERT INTO `achats` (`id`, `user_id`, `date_achat`, `prix_achat`) VALUES (1,2,'2026-04-05 07:07:57',8),(2,2,'2026-04-05 07:08:17',29),(3,2,'2026-04-05 18:31:06',17);
/*!40000 ALTER TABLE `achats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acteurs`
--

DROP TABLE IF EXISTS `acteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acteurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acteurs`
--

LOCK TABLES `acteurs` WRITE;
/*!40000 ALTER TABLE `acteurs` DISABLE KEYS */;
INSERT INTO `acteurs` (`id`, `name`) VALUES (1,'Miles Teller'),(2,'J.K. Simmons'),(3,'Brad Pitt'),(4,'Morgan Freeman'),(5,'Adrien Brody'),(6,'Omar Sy'),(7,'François Cluzet'),(8,'Matt Damon'),(9,'Robin Williams'),(10,'Tom Hanks'),(11,'Bruce Willis'),(12,'Matthew McConaughey'),(13,'Al Pacino'),(14,'Marlon Brando'),(15,'Liam Neeson'),(16,'Christian Bale'),(17,'Heath Ledger'),(18,'Russell Crowe'),(19,'Keanu Reeves'),(20,'Sam Worthington'),(21,'Ansel Elgort'),(22,'Tom Cruise'),(23,'Arnold Schwarzenegger');
/*!40000 ALTER TABLE `acteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `films`
--

DROP TABLE IF EXISTS `films`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `films` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `realisateur_id` int DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `Sortie` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `realisateur_id` (`realisateur_id`),
  CONSTRAINT `realisateur_id` FOREIGN KEY (`realisateur_id`) REFERENCES `realisateurs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `films`
--

LOCK TABLES `films` WRITE;
/*!40000 ALTER TABLE `films` DISABLE KEYS */;
INSERT INTO `films` (`id`, `description`, `titre`, `prix`, `image`, `realisateur_id`, `token`, `Sortie`) VALUES (1,'Un jeune batteur de jazz intègre un conservatoire d\'élite où il subit la pression psychologique et les méthodes tyranniques d\'un professeur.','Whiplash',9.00,'whisplash.webp',1,NULL,2014),(2,'Deux inspecteurs de police traquent un tueur en série méticuleux qui met en scène ses crimes selon les sept péchés capitaux.','Seven',8.00,'seven.jpg',2,NULL,1995),(3,'L\'histoire vraie de Wladyslaw Szpilman, un musicien juif polonais, luttant pour sa survie dans les ruines du ghetto de Varsovie.','Le Pianiste',9.00,'le_pianiste.jpg',3,NULL,2002),(4,'Le récit de l\'amitié improbable entre un riche aristocrate devenu tétraplégique et un jeune homme de banlieue engagé pour l\'aider.','Intouchables',7.00,'intouchables.jpg',4,NULL,2011),(5,'Un génie des mathématiques travaillant comme concierge au MIT doit affronter ses traumatismes passés avec l\'aide d\'un psychologue.','Good Will Hunting',8.00,'will_hunting.jpg',5,NULL,1997),(6,'Un gardien de prison dans le couloir de la mort découvre qu\'un condamné colossal possède un don mystérieux de guérison.','La Ligne verte',9.00,'ligne_verte.JPG',6,NULL,1999),(7,'Un policier de New York, seul et pieds nus, doit libérer les otages retenus par des terroristes dans un gratte-ciel.','Die Hard (Piège de Cristal)',7.00,'die_hard.jpg',7,NULL,1988),(8,'Alors que la Terre se meurt, un groupe d\'astronautes traverse un trou de ver pour trouver un futur foyer pour l\'humanité.','Interstellar',12.00,'interstellar.jpg',8,NULL,2014),(9,'Une fresque sur la puissante famille mafieuse Corleone et la transformation tragique du fils cadet en nouveau patriarche.','Le Parrain',14.00,'le_parrain.jpg',9,NULL,1972),(10,'Durant la Seconde Guerre mondiale, un industriel allemand sauve plus de 1 100 Juifs de l\'extermination en les employant.','La Liste de Schindler',10.00,'liste.jpg',10,NULL,1993),(11,'Batman affronte le Joker, un agent du chaos qui sème l\'anarchie à Gotham City pour tester les limites morales du héros.','The Dark Knight',11.00,'dark_knight.jpg',8,NULL,2008),(12,'Un général romain trahi par l\'héritier du trône devient esclave puis gladiateur pour venger le meurtre de sa famille.','Gladiator',9.00,'gladiator.jpg',11,NULL,2000),(13,'Un ancien tueur à gages sort de sa retraite pour traquer les mafieux qui ont tué son chien, ultime cadeau de sa femme.','John Wick',8.00,'john_wick.jpg',12,NULL,2014),(14,'Un hacker découvre que la réalité n\'est qu\'une simulation virtuelle créée par des machines pour asservir l\'humanité.','Matrix',9.00,'matrix.jpg',13,NULL,1999),(15,'Un Marine paraplégique est envoyé sur Pandora pour infiltrer le peuple Na\'vi, mais finit par mener leur bataille contre l\'exploitation humaine.','Avatar',12.00,'avatar.jpg',14,NULL,2009),(16,'Cinq tueurs à gages se retrouvent dans un train à grande vitesse au Japon et réalisent que leurs missions sont liées.','Bullet Train',10.00,'bullet_train.jpg',15,NULL,2022),(17,'Un agent du FBI infiltre une bande de surfeurs soupçonnés d\'être des braqueurs de banques.','Point Break',7.00,'point_break.jpg',16,NULL,1991),(18,'Un jeune chauffeur de braquage surdoué, qui conduit au rythme de ses playlists, tente de quitter le milieu criminel.','Baby Driver',9.00,'baby_driver.jpg',17,NULL,2017),(19,'Un pilote de chasse impétueux est envoyé dans une école d\'élite de la Navy où il doit faire face à une concurrence féroce.','Top Gun',6.00,'top_gun.jpg',18,NULL,1986),(20,'Un commando de forces spéciales en mission dans la jungle est traqué par une créature extraterrestre invisible.','Predator',7.00,'predator.jpg',7,NULL,1987);
/*!40000 ALTER TABLE `films` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` (`id`, `nom`) VALUES (1,'Drame'),(2,'Action');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liaisonActeurs`
--

DROP TABLE IF EXISTS `liaisonActeurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `liaisonActeurs` (
  `movie_id` int NOT NULL,
  `acteur_id` int NOT NULL,
  KEY `movie_id` (`movie_id`),
  KEY `acteur_id` (`acteur_id`),
  CONSTRAINT `liaisonacteurs_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `films` (`id`),
  CONSTRAINT `liaisonacteurs_ibfk_2` FOREIGN KEY (`acteur_id`) REFERENCES `acteurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liaisonActeurs`
--

LOCK TABLES `liaisonActeurs` WRITE;
/*!40000 ALTER TABLE `liaisonActeurs` DISABLE KEYS */;
INSERT INTO `liaisonActeurs` (`movie_id`, `acteur_id`) VALUES (1,1),(1,2),(2,3),(2,4),(3,5),(4,6),(4,7),(5,8),(5,9),(6,10),(7,11),(8,12),(9,13),(9,14),(10,15),(11,16),(11,17),(12,18),(13,19),(14,19),(15,20),(16,3),(17,19),(18,21),(19,22),(20,23);
/*!40000 ALTER TABLE `liaisonActeurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liaisonGenres`
--

DROP TABLE IF EXISTS `liaisonGenres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `liaisonGenres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `movie_id` int NOT NULL,
  `genre_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `genre_id` (`genre_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`),
  CONSTRAINT `movie_id` FOREIGN KEY (`movie_id`) REFERENCES `films` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liaisonGenres`
--

LOCK TABLES `liaisonGenres` WRITE;
/*!40000 ALTER TABLE `liaisonGenres` DISABLE KEYS */;
INSERT INTO `liaisonGenres` (`id`, `movie_id`, `genre_id`) VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,2),(8,8,1),(9,9,1),(10,10,1),(11,11,2),(12,12,2),(13,13,2),(14,14,2),(15,15,2),(16,16,2),(17,17,2),(18,18,2),(19,19,2),(20,20,2);
/*!40000 ALTER TABLE `liaisonGenres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `realisateurs`
--

DROP TABLE IF EXISTS `realisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `realisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `realisateurs`
--

LOCK TABLES `realisateurs` WRITE;
/*!40000 ALTER TABLE `realisateurs` DISABLE KEYS */;
INSERT INTO `realisateurs` (`id`, `name`) VALUES (1,'Damien Chazelle'),(2,'David Fincher'),(3,'Roman Polanski'),(4,'Olivier Nakache & Éric Toledano'),(5,'Gus Van Sant'),(6,'Frank Darabont'),(7,'John McTiernan'),(8,'Christopher Nolan'),(9,'Francis Ford Coppola'),(10,'Steven Spielberg'),(11,'Ridley Scott'),(12,'Chad Stahelski'),(13,'The Wachowskis'),(14,'James Cameron'),(15,'David Leitch'),(16,'Kathryn Bigelow'),(17,'Edgar Wright'),(18,'Tony Scott');
/*!40000 ALTER TABLE `realisateurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `motDePasse` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `pseudo`, `nom`, `prenom`, `motDePasse`, `email`, `token`) VALUES (2,'Ethan','Darnault','Ethan','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ethandrnlt@icloud.com','f3a60671a399cd45d370fa8f87071216cf43b173e874bfbee9dd99a402ecb71e'),(3,'test','Ethan','Darnault','$2y$10$3uC6867rWzurzAWquK6oreBPwSgdIyooJJtWxaK5CgfvulZJT91nO','ethan@gmail.com','317879ba378ea866ce79ef2b788142c7888b60fc86ed538f2760ba19479e9d95');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-05 18:47:16
