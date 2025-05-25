-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 25 mai 2025 à 13:27
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae_siteweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `niveau` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_utilisateur`, `niveau`) VALUES
(3, 18, '5');

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

DROP TABLE IF EXISTS `agent`;
CREATE TABLE IF NOT EXISTS `agent` (
  `id_agent` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `qualification` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_agent`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`id_agent`, `id_utilisateur`, `qualification`) VALUES
(1, 21, 'Accueil');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `num_etudiant` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `date_naissance` varchar(45) DEFAULT NULL,
  `TD` varchar(10) DEFAULT NULL,
  `TP` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`num_etudiant`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=125436 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`num_etudiant`, `id_utilisateur`, `date_naissance`, `TD`, `TP`) VALUES
(122055, 19, '2025-05-01', '1', 'B');

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `id_materiel` int NOT NULL AUTO_INCREMENT,
  `ref_materiel` varchar(45) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `etat` varchar(20) DEFAULT NULL,
  `quantite` varchar(45) DEFAULT NULL,
  `descriptif` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  PRIMARY KEY (`id_materiel`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `ref_materiel`, `nom`, `date_achat`, `etat`, `quantite`, `descriptif`, `image_url`, `categorie`) VALUES
(2, '1', 'tre', '0000-00-00', 'bon', '5', 'flemme', 'images/P1018463', 'trepied'),
(3, '1', 'cam2', '0000-00-00', 'bon', '5', 'flemme', 'images/IMG_0025', 'camera'),
(4, '1', 'micro', '0000-00-00', 'bon', '5', 'flemme', 'images/IMG_0019', 'micro'),
(45, '84512', 'drone', '2025-05-03', 'neuf', '3', 'sf', '../images/P1018443.JPG', 'camera'),
(123, 'h4', 'camera', '0000-00-00', 'bon', '5', 'rien a dire', 'images/20230505_105927.jpg', 'camera'),
(124, 'cam01', 'Caméra Sony', '2023-05-01', 'bon', '3', 'Caméra HD', 'images/20230505_100306.jpg', 'camera'),
(125, 'cam02', 'Caméra Canon', '2023-05-02', 'bon', '2', 'Caméra 4K', 'images/20230505_100614.jpg', 'camera'),
(126, 'cam03', 'Caméra Panasonic', '2023-05-03', 'bon', '4', 'Caméra compacte', 'images/20230505_100647.jpg', 'camera'),
(127, 'cam04', 'Caméra GoPro', '2023-05-04', 'bon', '5', 'Caméra sport', 'images/20230505_100649.jpg', 'camera'),
(128, 'mic01', 'Micro Rode', '2023-05-05', 'bon', '6', 'Microphone studio', 'images/20230505_100918.jpg', 'micro'),
(129, 'mic02', 'Micro Shure', '2023-05-06', 'bon', '3', 'Micro dynamique', 'images/20230505_101201.jpg', 'micro'),
(130, 'mic03', 'Micro AKG', '2023-05-07', 'bon', '2', 'Micro chant', 'images/20230505_101540.jpg', 'micro'),
(131, 'mic04', 'Micro Sennheiser', '2023-05-08', 'bon', '4', 'Micro cravate', 'images/20230505_102025.jpg', 'micro'),
(132, 'tre01', 'Trépied Manfrotto', '2023-05-09', 'bon', '5', 'Trépied vidéo', 'images/20230505_103315.jpg', 'trepied'),
(133, 'tre02', 'Trépied Benro', '2023-05-10', 'bon', '3', 'Trépied photo', 'images/20230505_104109.jpg', 'trepied'),
(134, 'tre03', 'Trépied Vanguard', '2023-05-11', 'bon', '2', 'Trépied léger', 'images/20230505_104216.jpg', 'trepied'),
(135, 'tre04', 'Trépied Gitzo', '2023-05-12', 'bon', '1', 'Trépied carbone', 'images/20230505_104425.jpg', 'trepied'),
(136, 'lum01', 'Lumière LED Aputure', '2023-05-13', 'bon', '4', 'Lumière portable', 'images/20230505_104558.jpg', 'lumiere'),
(137, 'lum02', 'Lumière Godox', '2023-05-14', 'bon', '2', 'Lumière studio', 'images/20230505_104611.jpg', 'lumiere'),
(138, 'lum03', 'Lumière Neewer', '2023-05-15', 'bon', '3', 'Lumière anneau', 'images/20230505_105255.jpg', 'lumiere'),
(139, 'lum04', 'Lumière Yongnuo', '2023-05-16', 'bon', '2', 'Lumière RGB', 'images/20230505_105442.jpg', 'lumiere'),
(140, 'acc01', 'Batterie Sony', '2023-05-17', 'bon', '6', 'Batterie longue durée', 'images/20230505_105700.jpg', 'accessoire'),
(141, 'acc02', 'Carte SD Sandisk', '2023-05-18', 'bon', '10', 'Carte mémoire 64Go', 'images/20230505_105908.jpg', 'accessoire'),
(142, 'acc03', 'Sac Lowepro', '2023-05-19', 'bon', '2', 'Sac de transport', 'images/20230505_105927.jpg', 'accessoire'),
(143, 'acc04', 'Chargeur Canon', '2023-05-20', 'bon', '3', 'Chargeur rapide', 'images/20230505_110146.jpg', 'accessoire');

-- --------------------------------------------------------

--
-- Structure de la table `materiel_emprunt`
--

DROP TABLE IF EXISTS `materiel_emprunt`;
CREATE TABLE IF NOT EXISTS `materiel_emprunt` (
  `id_emprunt` int NOT NULL AUTO_INCREMENT,
  `id_reservation` int NOT NULL,
  `id_materiel` int NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`id_emprunt`),
  KEY `id_reservation` (`id_reservation`),
  KEY `id_materiel` (`id_materiel`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `materiel_emprunt`
--

INSERT INTO `materiel_emprunt` (`id_emprunt`, `id_reservation`, `id_materiel`, `quantite`) VALUES
(15, 21, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `id_reservation` int DEFAULT NULL,
  `contenu` text,
  `date_message` date DEFAULT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_reservation` (`id_reservation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `id_professeur` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `diplome` varchar(45) DEFAULT NULL,
  `qualification` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_professeur`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id_professeur`, `id_utilisateur`, `diplome`, `qualification`) VALUES
(5, 20, 'diplome', 'Git');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `date_emprunt` date NOT NULL,
  `heure_acces` time NOT NULL,
  `heure_rendu` time NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `etat` varchar(20) NOT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_user`, `date_emprunt`, `heure_acces`, `heure_rendu`, `commentaire`, `etat`) VALUES
(21, 18, '2025-05-01', '15:15:00', '16:15:00', 'grg', 'en attente'),
(22, 20, '2025-05-05', '14:50:00', '13:50:00', 'ytdrzejg', 'annulée');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `capacite` varchar(255) DEFAULT NULL,
  `equipement1` varchar(255) DEFAULT NULL,
  `equipement2` varchar(255) DEFAULT NULL,
  `equipement3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `nom`, `capacite`, `equipement1`, `equipement2`, `equipement3`) VALUES
(44, '202', '30', 'projecteur', 'pc', NULL),
(45, '203', '30', 'projecteur', '', NULL),
(46, '205', '30', 'pc', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `salle_emprunt`
--

DROP TABLE IF EXISTS `salle_emprunt`;
CREATE TABLE IF NOT EXISTS `salle_emprunt` (
  `id_salle_emprunt` int NOT NULL AUTO_INCREMENT,
  `id_reservation` int NOT NULL,
  `id_salle` int NOT NULL,
  `equipement1` varchar(255) DEFAULT NULL,
  `equipement2` varchar(255) DEFAULT NULL,
  `equipement3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_salle_emprunt`),
  KEY `id_reservation` (`id_reservation`),
  KEY `id_salle` (`id_salle`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `salle_emprunt`
--

INSERT INTO `salle_emprunt` (`id_salle_emprunt`, `id_reservation`, `id_salle`, `equipement1`, `equipement2`, `equipement3`) VALUES
(1, 21, 44, NULL, NULL, NULL),
(2, 22, 44, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `prenom` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pseudo` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `telephone` int NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `etat` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `pseudo`, `email`, `mot_de_passe`, `adresse`, `telephone`, `role`, `etat`) VALUES
(21, 'agent', 'agent', 'agent', 'agent@gmail.com', '$2y$10$YwP/JAstiRsjcAnetSDqtOie1003XFbaIRuzJ6USqN98WD0vUJxD6', 'adresse', 123456789, 'agent', 'valider'),
(20, 'Tir', 'Fouard', 'professeur', 'tir@gmail.com', '$2y$10$L.p8qB9qnf2BB2KWTcp9i.eyNW3AU6voqdDLenija2pWIBDp.IF.2', 'adresse', 123456789, 'enseignant', 'valider'),
(19, 'etudiant', 'etudiant', 'etudiant', 'etudiant@gmail.com', '$2y$10$p7m..eXWt8DKEikGcMpLM.us1bVKfvxk8XeTz6Wt6LOZGikqCOh8a', 'adresse', 123456789, 'etudiant', 'valider'),
(18, 'admin', 'admin', 'admin', 'admin@gmail.com', '$2y$10$nFnaah4syFX0wAQwBxka2uClrA18BAqkQiY6lfpRecqfaA8X1CZzW', 'adresse', 123456789, 'admin', 'valider');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `materiel_emprunt`
--
ALTER TABLE `materiel_emprunt`
  ADD CONSTRAINT `materiel_emprunt_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`) ON DELETE CASCADE,
  ADD CONSTRAINT `materiel_emprunt_ibfk_2` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
