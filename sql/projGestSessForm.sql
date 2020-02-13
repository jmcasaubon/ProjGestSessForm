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

-- Listage des données de la table projgestsessform.categorie : ~4 rows (environ)
DELETE FROM `categorie`;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `libelle`) VALUES
	(1, 'Bureautique'),
	(2, 'Développemen Web'),
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.module : ~11 rows (environ)
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
	(13, 5, 'Méthodologies', 3);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Listage de la structure de la table projgestsessform. programme
DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.programme : ~8 rows (environ)
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
	(9, 2, 11, 20);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.session : ~2 rows (environ)
DELETE FROM `session`;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `intitule`, `date_debut`, `date_fin`, `nb_places`) VALUES
	(1, 'Initiation bureautique', '2020-03-02', '2020-03-13', 12),
	(2, 'Développeur Web', '2020-02-17', '2020-06-12', 10);
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

-- Listage des données de la table projgestsessform.session_stagiaire : ~4 rows (environ)
DELETE FROM `session_stagiaire`;
/*!40000 ALTER TABLE `session_stagiaire` DISABLE KEYS */;
INSERT INTO `session_stagiaire` (`session_id`, `stagiaire_id`) VALUES
	(1, 6),
	(1, 8),
	(2, 4),
	(2, 5),
	(2, 9);
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
  `telephone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projgestsessform.stagiaire : ~9 rows (environ)
DELETE FROM `stagiaire`;
/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `sexe`, `date_naissance`, `adresse`, `cpostal`, `ville`, `telephone`, `mail`) VALUES
	(1, 'Dupont', 'Michel', 'M', '1999-01-16', '27 av. Rockfeller', '69008', 'Lyon', NULL, 'michel.dupont@gmail.com'),
	(2, 'Dupont', 'Sandrine', 'F', '2000-02-14', '202 av. de Colmar', '67000', 'Strasbourg', NULL, 'sandrine.dupont@gmail.com'),
	(3, 'Dupond', 'Paul', 'M', '1999-09-27', '12 rue Casimir Périer', '69002', 'Lyon', NULL, 'paul.dupond@hotmail.com'),
	(4, 'Durand', 'Michel', 'M', '1999-07-21', '21 rue de Lyon', '68000', 'Mulhouse', NULL, 'michel.durand@hotmail.com'),
	(5, 'Martin', 'Arthur', 'M', '2000-03-01', 'Allées des cuisines', '44730', 'St-Michel-Chef-Chef', NULL, 'arthur.martin@gmail.com'),
	(6, 'Darc', 'Jeanne', 'F', '1999-12-31', 'Rue de l\'Annociation', '88630', 'Domremy', NULL, 'jeanne.darc@hotmail.com'),
	(7, 'Dubois', 'Aline', 'F', '2000-01-03', 'Allée de la forêt', '91665', 'La Ville-du-Bois', NULL, 'aline.dubois@gmail.com'),
	(8, 'Lamère', 'Michèle', 'F', '1999-11-30', 'Avenue du Matou Matheux', '77370', 'La Chapelle-du-Mont-du-Chat', NULL, 'michele.lamere@gmail.com'),
	(9, 'Moreau', 'Jean', 'M', '1999-06-02', '11 rue Sainte Barbe', '67260', 'Rimsdorf', NULL, 'jean.moreau@hotmail.com');
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
