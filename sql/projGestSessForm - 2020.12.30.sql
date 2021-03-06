-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour projgestsessform
DROP DATABASE IF EXISTS `projgestsessform`;
CREATE DATABASE IF NOT EXISTS `projgestsessform` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `projgestsessform`;

-- Listage de la structure de la table projgestsessform. categorie
DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.categorie : ~5 rows (environ)
DELETE FROM `categorie`;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `libelle`) VALUES
	(1, 'Bureautique'),
	(2, 'Développement Web'),
	(3, 'Infographie'),
	(4, 'P.A.O.'),
	(5, 'Gestion de projet');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. migration_versions
DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.migration_versions : ~0 rows (environ)
DELETE FROM `migration_versions`;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
	('20200212085531', '2020-02-12 08:59:08');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. module
DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `libelle` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree_suggeree` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.module : ~15 rows (environ)
DELETE FROM `module`;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `categorie_id`, `libelle`, `duree_suggeree`) VALUES
	(1, 1, 'Word', 5),
	(2, 1, 'Excel', 4),
	(3, 1, 'Powerpoint', 3),
	(4, 2, 'PHP/CSS', 10),
	(5, 2, 'SQL', 5),
	(6, 2, 'JavaScript', 2),
	(7, 3, 'Photoshop', 3),
	(8, 3, 'Illustrator', 3),
	(9, 3, 'InDesign', 4),
	(10, 4, 'Publisher', 3),
	(11, 2, 'Frameworks', 3),
	(12, 5, 'Planification (Gantt/Pert...)', 2),
	(13, 5, 'Méthodologies', 3),
	(14, 4, 'Spark', 3),
	(15, 5, 'XD', 3);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. programme
DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `programme_unique` (`module_id`,`session_id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.programme : ~23 rows (environ)
DELETE FROM `programme`;
/*!40000 ALTER TABLE `programme` DISABLE KEYS */;
INSERT INTO `programme` (`id`, `session_id`, `module_id`, `duree`) VALUES
	(1, 1, 1, 3),
	(2, 1, 2, 4),
	(3, 1, 3, 3),
	(4, 2, 4, 5),
	(5, 2, 6, 3),
	(6, 2, 5, 2),
	(7, 2, 12, 2),
	(8, 2, 13, 3),
	(9, 2, 11, 20),
	(10, 3, 1, 3),
	(11, 3, 2, 3),
	(12, 3, 10, 4),
	(13, 5, 1, 6),
	(15, 5, 10, 5),
	(16, 5, 3, 2),
	(17, 6, 8, 5),
	(18, 6, 9, 5),
	(19, 6, 15, 5),
	(20, 4, 4, 4),
	(21, 4, 6, 4),
	(22, 4, 11, 2),
	(23, 7, 10, 5),
	(24, 7, 14, 5);
/*!40000 ALTER TABLE `programme` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. session
DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nb_places` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.session : ~7 rows (environ)
DELETE FROM `session`;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `intitule`, `date_debut`, `date_fin`, `nb_places`) VALUES
	(1, 'Initiation bureautique', '2020-03-02', '2020-03-13', 12),
	(2, 'Développeur Web', '2020-02-17', '2020-06-12', 10),
	(3, 'Bureautique avancée', '2020-03-16', '2020-03-27', 12),
	(4, 'Intégrateur Web', '2020-03-02', '2020-03-13', 10),
	(5, 'Session de test', '2020-02-27', '2020-03-11', 2),
	(6, 'Infographie', '2020-01-06', '2020-01-25', 8),
	(7, 'Une session à supprimer', '2020-02-29', '2020-03-13', 2);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. session_stagiaire
DROP TABLE IF EXISTS `session_stagiaire`;
CREATE TABLE IF NOT EXISTS `session_stagiaire` (
  `session_id` int(11) NOT NULL,
  `stagiaire_id` int(11) NOT NULL,
  PRIMARY KEY (`session_id`,`stagiaire_id`),
  KEY `IDX_C80B23B613FECDF` (`session_id`),
  KEY `IDX_C80B23BBBA93DD6` (`stagiaire_id`),
  CONSTRAINT `FK_C80B23B613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C80B23BBBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.session_stagiaire : ~13 rows (environ)
DELETE FROM `session_stagiaire`;
/*!40000 ALTER TABLE `session_stagiaire` DISABLE KEYS */;
INSERT INTO `session_stagiaire` (`session_id`, `stagiaire_id`) VALUES
	(1, 6),
	(1, 10),
	(2, 4),
	(2, 5),
	(2, 9),
	(3, 6),
	(4, 2),
	(4, 7),
	(5, 8),
	(5, 10),
	(6, 2),
	(6, 8),
	(6, 11);
/*!40000 ALTER TABLE `session_stagiaire` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. stagiaire
DROP TABLE IF EXISTS `stagiaire`;
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpostal` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(63) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(23) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4F62F7315126AC48` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.stagiaire : ~11 rows (environ)
DELETE FROM `stagiaire`;
/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `sexe`, `date_naissance`, `adresse`, `cpostal`, `ville`, `telephone`, `mail`) VALUES
	(1, 'Dupont', 'Michel', 'M', '1999-01-16', '27 av. Rockfeller', '69008', 'Lyon', '(+33) 4.56.78.90.12', 'michel.dupont@gmail.com'),
	(2, 'Dupont', 'Sandrine', 'F', '2000-02-14', '202 av. de Colmar', '67000', 'Strasbourg', '(+33) 3.45.67.89.01', 'sandrine.dupont@gmail.com'),
	(3, 'Dupond', 'Paul', 'M', '1999-09-27', '12 rue Casimir Périer', '69002', 'Lyon', '(+33) 4.32.10.98.76', 'paul.dupond@hotmail.com'),
	(4, 'Durand', 'Michel', 'M', '1999-07-21', '21 rue de Lyon', '68000', 'Mulhouse', '(+33) 3.21.09.87.65', 'michel.durand@hotmail.com'),
	(5, 'Martin', 'Arthur', 'M', '2000-03-01', 'Allées des cuisines', '44730', 'St-Michel-Chef-Chef', '(+33) 2.34.56.78.90', 'arthur.martin@gmail.com'),
	(6, 'Darc', 'Jeanne', 'F', '1999-12-31', 'Rue de l\'Annonciation', '88000', 'Épinal', '(+33) 3.57.91.24.68', 'jeanne.darc@hotmail.com'),
	(7, 'Dubois', 'Aline', 'F', '2000-01-03', 'Allée de la forêt', '91665', 'La Ville-du-Bois', '(+33) 1.23.45.67.89', 'aline.dubois@gmail.com'),
	(8, 'Lamère', 'Michèle', 'F', '1999-11-30', 'Avenue du Matou Matheux', '77370', 'La Chapelle-du-Mont-du-Chat', '(+33) 1.09.87.65.43', 'michele.lamere@gmail.com'),
	(9, 'Moreau', 'Jean', 'M', '1999-06-02', '11 rue Sainte Barbe', '67260', 'Rimsdorf', '(+33) 6.78.90.12.34', 'jean.moreau@hotmail.com'),
	(10, 'Casaubon', 'Jean-Michel', 'M', '1965-06-02', '38 Grand\'Rue', '67430', 'Butten', '(+33) 6.38.26.16.22', 'jm_casaubon@orange.fr'),
	(11, 'Doe', 'John', 'M', '1965-02-28', 'wsdfghjkolp', 'xdcfgh', 'wsxdcfbjkl', 'xdfgyhukpm^ù$', 'a@b.c');
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D64986CC499D` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.user : ~2 rows (environ)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`) VALUES
	(1, 'jmcasaubon@gmail.com', '["ROLE_ADMIN"]', '$argon2id$v=19$m=65536,t=4,p=1$QXZOdVlueE92RkJaMzF6dw$t2ue+CObDPQvIiwD9wkubDyBvZpZgPHYzMen/IsVPHA', 'jmc'),
	(4, 'jm_casaubon@orange.fr', '[]', '$argon2id$v=19$m=65536,t=4,p=1$TjdqbFZYOGR3SzhRbDMzTg$4s5Bhqc0evN6Df8mKWtijXQd2uz2Ko2T4gLixhtC9cQ', 'jmc-65');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
