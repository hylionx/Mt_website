-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 01 avr. 2019 à 12:07
-- Version du serveur :  10.2.12-MariaDB
-- Version de PHP :  7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mt_website`
--

-- --------------------------------------------------------

--
-- Structure de la table `bateau`
--

CREATE TABLE `bateau` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `largeur` int(11) NOT NULL DEFAULT 0,
  `longueur` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bateau`
--

INSERT INTO `bateau` (`id`, `libelle`, `largeur`, `longueur`) VALUES
(1, 'Kor\' Ant', 15, 15),
(2, 'Ar Solen', 12, 0),
(3, 'Axxx', 13, 41),
(4, 'Luce isle', 29, 20),
(5, 'Maëllys', 30, 5),
(6, 'Fret', 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `bateau_caracteristique`
--

CREATE TABLE `bateau_caracteristique` (
  `bateau` int(11) NOT NULL,
  `transport` int(11) NOT NULL,
  `nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bateau_caracteristique`
--

INSERT INTO `bateau_caracteristique` (`bateau`, `transport`, `nombre`) VALUES
(1, 1, 238),
(1, 2, 11),
(1, 3, 2),
(2, 1, 276),
(2, 2, 5),
(2, 3, 1),
(3, 1, 250),
(3, 2, 3),
(3, 3, 0),
(4, 1, 155),
(4, 2, 0),
(4, 3, 0),
(5, 1, 132),
(5, 2, 0),
(5, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `bateau_fret`
--

CREATE TABLE `bateau_fret` (
  `id_bateau` int(11) NOT NULL,
  `point_max` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bateau_fret`
--

INSERT INTO `bateau_fret` (`id_bateau`, `point_max`) VALUES
(6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `bateau_voyageur`
--

CREATE TABLE `bateau_voyageur` (
  `id_bateau` int(11) NOT NULL,
  `vitesse` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bateau_voyageur`
--

INSERT INTO `bateau_voyageur` (`id_bateau`, `vitesse`, `image`) VALUES
(1, 4, '1.jpg'),
(2, 4, '2.jpg'),
(3, 4, '3.jpg'),
(4, 4, '4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `bateau_voyageur_equipement`
--

CREATE TABLE `bateau_voyageur_equipement` (
  `id_bateau` int(11) NOT NULL,
  `id_equipement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bateau_voyageur_equipement`
--

INSERT INTO `bateau_voyageur_equipement` (`id_bateau`, `id_equipement`) VALUES
(1, 1),
(1, 2),
(3, 3),
(3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `cp` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL DEFAULT '',
  `admin` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `ville`, `cp`, `adresse`, `points`, `email`, `password`, `token`, `admin`) VALUES
(1, 'Thomine', 'Quentin', 'Le vile', '50400', '34 rue des petites fleurs', 50, 'robbou@hotmail.fr', 'ab4f63f9ac65152575886860dde480a1', 'atqqxuu291g580qw2gc5h1j3i1r67k2h9wm2n82qgb0q816099whv000c2shscvie015401l5feu92vxuqmtxv6r5a9ndc62djkh', '1'),
(2, 'George', 'Adrien', 'Lille', '59000', '23 rue des pommes', 0, 'adrien-george@outlook.fr', '5ba7326071461c18e426b7a59aa3a51e', '0', '1'),
(3, 'Boudahba', 'Hylia', 'Tourcoing', '59200', '45 rue des près', 0, 'hylia.boudahba@gmail.com', 'ab4f63f9ac65152575886860dde480a1', '0', '1');

-- --------------------------------------------------------

--
-- Structure de la table `client_caracteristique`
--

CREATE TABLE `client_caracteristique` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `transport_type` int(11) NOT NULL,
  `nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client_caracteristique`
--

INSERT INTO `client_caracteristique` (`id`, `reservation_id`, `transport_type`, `nombre`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 2, 1, 1),
(4, 3, 1, 4),
(5, 3, 2, 2),
(6, 3, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `client_reservation`
--

CREATE TABLE `client_reservation` (
  `id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `traversee` int(11) NOT NULL,
  `prix_final` float NOT NULL DEFAULT 0,
  `times` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client_reservation`
--

INSERT INTO `client_reservation` (`id`, `client`, `traversee`, `prix_final`, `times`) VALUES
(1, 1, 1, 13, 1551688512),
(2, 1, 2, 20, 1551688617),
(3, 1, 9, 84, 1551706285);

--
-- Déclencheurs `client_reservation`
--
DELIMITER $$
CREATE TRIGGER `add_pts` BEFORE INSERT ON `client_reservation` FOR EACH ROW BEGIN

IF (SELECT id FROM client WHERE points >= 100 AND id = NEW.client) IS NOT NULL THEN
    SET NEW.prix_final = NEW.prix_final-(NEW.prix_final*25/100);
    UPDATE client SET points = points-100 WHERE id = NEW.client;
    
ELSEIF (SELECT id FROM traversee WHERE id = NEW.traversee AND date_depart > (UNIX_TIMESTAMP()+5184000)) IS NOT NULL THEN
        UPDATE client SET points = points+25 WHERE id = NEW.client;
    END IF; 
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `sujet`, `message`) VALUES
(1, 'Paul', 'paul@gmail.com', 'Au sujet des paiements', 'Bonjour, \r\n\r\nProposez-vous les paiements par chèque ?\r\n\r\nCordialement');

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `equipement`
--

INSERT INTO `equipement` (`id`, `libelle`) VALUES
(1, 'Toilettes'),
(2, 'Bar'),
(3, 'Piscine'),
(4, 'Salon vidéo'),
(5, 'Accès handicapé');

-- --------------------------------------------------------

--
-- Structure de la table `liaison`
--

CREATE TABLE `liaison` (
  `id` int(11) NOT NULL,
  `secteur` int(11) NOT NULL,
  `distance` float NOT NULL,
  `depart` int(11) NOT NULL,
  `arrivee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liaison`
--

INSERT INTO `liaison` (`id`, `secteur`, `distance`, `depart`, `arrivee`) VALUES
(1, 1, 8.3, 1, 2),
(2, 1, 9, 2, 1),
(3, 1, 8, 1, 3),
(4, 1, 7.9, 3, 1),
(5, 1, 23.7, 4, 2),
(6, 1, 25.1, 2, 4),
(7, 2, 8.8, 1, 5),
(8, 2, 8.8, 5, 1),
(9, 3, 7.7, 7, 6),
(10, 3, 7.4, 6, 7);

-- --------------------------------------------------------

--
-- Structure de la table `liaison_secteur`
--

CREATE TABLE `liaison_secteur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liaison_secteur`
--

INSERT INTO `liaison_secteur` (`id`, `nom`, `image`, `description`) VALUES
(1, 'Belle-Île-en-mer', 'belle-ile-en-mer.jpg', 'Belle-Île-en-Mer, parfois surnommée simplement « Belle-Île » est une île française du golfe de Gascogne située dans le département du Morbihan, dans le sud de la Bretagne.'),
(2, 'Houat', 'houat.jpg', 'Houat est une île de la côte morbihannaise, en Bretagne, située à 10 km au sud-est de la pointe du Conguel, sur la presqu\'île de Quiberon. '),
(3, 'Ile de Groix', 'Ile-de-Groix.jpg', 'Groix est une île et une commune bretonne du département du Morbihan. Elle se trouve dans le golfe de Gascogne, au large de la côte sud de la Bretagne, au nord-ouest de Belle-Île-en-Mer et en face de Ploemeur. '),
(4, 'Ouessant', 'ouessant.jpg', 'L\'île d\'Ouessant est une île française de la mer Celtique située à l’ouest de la partie continentale de la Bretagne.'),
(5, 'Molène', 'molene.jpg', 'Molène est une île de la mer Celtique située à 12 km à l\'ouest de la pointe de Corsen, sur la côte occidentale du Finistère, en Bretagne.'),
(6, 'Sein', 'sein.jpg', 'L\'île de Sein est une île de Bretagne située dans le Sud-Est de la mer Celtique, à 7,20 kilomètres à l\'ouest de la pointe du Raz dont elle est séparée par le Raz de Sein.'),
(7, 'Bréhat', 'brehat.jpg', 'Île-de-Bréhat est une commune française située dans le département des Côtes-d\'Armor au nord de la pointe de l\'Arcouest en Bretagne. Elle est constituée de l\'archipel de Bréhat, qui doit son nom à l\'île principale, dénommée Bréhat.'),
(8, 'Batz', 'batz.jpg', 'Île-de-Batz, est une commune française située dans le nord du département du Finistère (dans le Léon), en région Bretagne.'),
(9, 'Aix', 'aix.jpg', 'Île-d\'Aix est une commune à part entière du sud-ouest de la France. L\'île d\'Aix est située à l\'ouest au large de la pointe de la Fumée, qui est l\'extrémité de la presqu\'île de Fouras, et à l\'est de l\'île d\'Oléron. Elle est la plus petite commune du département de la Charente-Maritime, dans la région Nouvelle-Aquitaine.'),
(10, 'Yeu', 'yeu.jpg', 'L\'Île-d\'Yeu est une commune française, située dans le département de la Vendée en région Pays de la Loire. C\'est une commune insulaire, constituée de l\'île d\'Yeu, l\'une des quinze îles du Ponant. Elle constitue également le canton de l\'Île-d\'Yeu.');

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `date_debut` int(11) NOT NULL,
  `date_fin` int(11) NOT NULL,
  `liaison` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `periode`
--

INSERT INTO `periode` (`id`, `date_debut`, `date_fin`, `liaison`) VALUES
(33, 1551394800, 1559340000, 10),
(34, 1551394800, 1559340000, 9),
(35, 1551394800, 1559340000, 8),
(36, 1551394800, 1559340000, 7),
(37, 1551394800, 1559340000, 6),
(38, 1551394800, 1559340000, 5),
(39, 1551394800, 1559340000, 4),
(40, 1551394800, 1559340000, 3),
(41, 1551394800, 1559340000, 2),
(42, 1551394800, 1559340000, 1),
(43, 1559426400, 1567288800, 10),
(44, 1559426400, 1567288800, 9),
(45, 1559426400, 1567288800, 8),
(46, 1559426400, 1567288800, 7),
(47, 1559426400, 1567288800, 6),
(48, 1559426400, 1567288800, 5),
(49, 1559426400, 1567288800, 4),
(50, 1559426400, 1567288800, 3),
(51, 1559426400, 1567288800, 2),
(52, 1559426400, 1567288800, 1);

-- --------------------------------------------------------

--
-- Structure de la table `periode_transport`
--

CREATE TABLE `periode_transport` (
  `id` int(11) NOT NULL,
  `periode` int(11) NOT NULL,
  `transport_type` int(11) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `periode_transport`
--

INSERT INTO `periode_transport` (`id`, `periode`, `transport_type`, `prix`) VALUES
(1, 52, 1, 10),
(2, 52, 3, 5),
(3, 52, 2, 8),
(4, 52, 4, 40),
(5, 52, 7, 50),
(6, 52, 6, 70),
(7, 51, 1, 15),
(8, 51, 3, 5),
(9, 51, 2, 8),
(10, 50, 1, 14),
(11, 50, 3, 8),
(12, 50, 2, 6),
(13, 49, 1, 10),
(14, 50, 4, 5),
(15, 48, 1, 15),
(16, 34, 1, 5),
(17, 35, 1, 6),
(18, 36, 1, 7),
(19, 37, 1, 6),
(20, 38, 1, 9),
(21, 39, 1, 9),
(22, 40, 1, 15),
(23, 41, 1, 12),
(24, 43, 1, 34),
(25, 44, 1, 20),
(26, 45, 1, 4),
(27, 46, 1, 5),
(28, 47, 1, 10),
(29, 41, 3, 10),
(30, 41, 2, 5),
(31, 35, 7, 5),
(32, 42, 1, 5),
(33, 42, 3, 2),
(34, 42, 2, 4),
(35, 33, 1, 6),
(36, 33, 3, 5),
(37, 33, 2, 5),
(38, 33, 4, 30),
(39, 33, 5, 40),
(40, 33, 8, 5),
(41, 34, 3, 5),
(42, 34, 2, 5),
(43, 33, 7, 30),
(44, 35, 3, 5),
(45, 35, 2, 5),
(46, 49, 3, 5),
(47, 49, 2, 5),
(48, 49, 4, 20),
(49, 49, 5, 15),
(50, 48, 3, 5),
(51, 47, 3, 5),
(52, 47, 2, 5),
(53, 47, 4, 15),
(54, 47, 5, 30),
(55, 47, 8, 40),
(56, 47, 7, 45),
(57, 47, 6, 50),
(58, 46, 6, 50),
(59, 46, 7, 45),
(60, 46, 8, 45),
(61, 46, 5, 40),
(62, 46, 4, 30),
(63, 46, 2, 9),
(64, 46, 3, 6),
(65, 45, 3, 6),
(66, 45, 2, 11),
(67, 45, 4, 20),
(68, 45, 5, 25),
(69, 45, 8, 40),
(70, 45, 7, 50),
(71, 45, 6, 45),
(72, 44, 6, 45),
(73, 44, 7, 36),
(74, 44, 8, 30),
(75, 44, 5, 30),
(76, 44, 4, 20),
(77, 44, 2, 9),
(78, 44, 3, 5),
(79, 43, 3, 5),
(80, 43, 2, 8),
(81, 43, 4, 20),
(82, 43, 5, 25),
(83, 43, 8, 30),
(84, 43, 7, 40),
(85, 43, 6, 50),
(86, 42, 6, 55),
(87, 42, 7, 50),
(88, 42, 8, 55),
(89, 42, 5, 45),
(90, 42, 4, 40),
(91, 40, 3, 4),
(92, 40, 2, 10),
(93, 40, 4, 20),
(94, 40, 5, 24),
(95, 40, 8, 30),
(96, 40, 7, 35),
(97, 40, 6, 45),
(98, 39, 6, 45),
(99, 39, 7, 45),
(100, 39, 8, 45),
(101, 39, 5, 40),
(102, 39, 4, 35),
(103, 39, 2, 10),
(104, 39, 3, 5),
(105, 38, 3, 5),
(106, 38, 2, 7),
(107, 38, 4, 10),
(108, 38, 5, 15),
(109, 38, 8, 20),
(110, 38, 7, 20),
(111, 38, 6, 20),
(112, 37, 6, 20),
(113, 37, 7, 20),
(114, 37, 8, 20),
(115, 37, 5, 15),
(116, 37, 4, 14),
(117, 37, 2, 10),
(118, 37, 3, 10),
(119, 36, 3, 10),
(120, 36, 2, 10),
(121, 36, 4, 15),
(122, 36, 5, 17),
(123, 36, 8, 30),
(124, 36, 7, 30),
(125, 36, 6, 30),
(126, 35, 6, 30),
(127, 35, 8, 30),
(128, 35, 4, 25),
(129, 34, 4, 20),
(130, 34, 5, 20),
(131, 34, 8, 25),
(132, 34, 7, 25),
(133, 34, 6, 25);

-- --------------------------------------------------------

--
-- Structure de la table `port`
--

CREATE TABLE `port` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `port`
--

INSERT INTO `port` (`id`, `libelle`) VALUES
(1, 'Quiberon'),
(2, 'Le Palais'),
(3, 'Sauzon'),
(4, 'Vannes'),
(5, 'Port St Gildas'),
(6, 'Port-Tudy'),
(7, 'Lorient');

-- --------------------------------------------------------

--
-- Structure de la table `transport_categorie`
--

CREATE TABLE `transport_categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transport_categorie`
--

INSERT INTO `transport_categorie` (`id`, `libelle`) VALUES
(1, 'passager'),
(2, 'véh.inf.2m'),
(3, 'véh.sup.2m ');

-- --------------------------------------------------------

--
-- Structure de la table `transport_type`
--

CREATE TABLE `transport_type` (
  `id` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transport_type`
--

INSERT INTO `transport_type` (`id`, `categorie`, `libelle`) VALUES
(1, 1, 'adulte'),
(2, 1, 'junior 8 à 18 ans'),
(3, 1, 'enfant 0 à 7 ans'),
(4, 2, 'voiture < 4m'),
(5, 2, 'voiture long < 5m'),
(6, 3, 'fourgon'),
(7, 3, 'camping Car'),
(8, 3, 'camion');

-- --------------------------------------------------------

--
-- Structure de la table `traversee`
--

CREATE TABLE `traversee` (
  `id` int(11) NOT NULL,
  `date_depart` int(11) NOT NULL,
  `date_arrivee` int(11) NOT NULL,
  `bateau` int(11) NOT NULL,
  `liaison` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `traversee`
--

INSERT INTO `traversee` (`id`, `date_depart`, `date_arrivee`, `bateau`, `liaison`) VALUES
(1, 1554708300, 1554798300, 5, 1),
(2, 1564903560, 1564907160, 4, 9),
(3, UNIX_TIMESTAMP()+3600, UNIX_TIMESTAMP()+7200, 3, 9),
(4, UNIX_TIMESTAMP()+172800, UNIX_TIMESTAMP()+176400, 2, 6),
(5, UNIX_TIMESTAMP()+3600, UNIX_TIMESTAMP()+7200, 2, 2),
(6, UNIX_TIMESTAMP()+3600, UNIX_TIMESTAMP()+7200, 2, 8),
(7, UNIX_TIMESTAMP()+3600, UNIX_TIMESTAMP()+7200, 4, 10),
(8, UNIX_TIMESTAMP()+172800, UNIX_TIMESTAMP()+176400, 4, 1),
(9, UNIX_TIMESTAMP()+86400, UNIX_TIMESTAMP()+90000, 3, 3),
(10, UNIX_TIMESTAMP()+86400, UNIX_TIMESTAMP()+90000, 2, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bateau`
--
ALTER TABLE `bateau`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bateau_caracteristique`
--
ALTER TABLE `bateau_caracteristique`
  ADD KEY `bateau` (`bateau`),
  ADD KEY `bateau_caracteristique_ibfk_2` (`transport`);

--
-- Index pour la table `bateau_fret`
--
ALTER TABLE `bateau_fret`
  ADD PRIMARY KEY (`id_bateau`);

--
-- Index pour la table `bateau_voyageur`
--
ALTER TABLE `bateau_voyageur`
  ADD UNIQUE KEY `id_bateau` (`id_bateau`);

--
-- Index pour la table `bateau_voyageur_equipement`
--
ALTER TABLE `bateau_voyageur_equipement`
  ADD KEY `bateau_voyageur_equipement_ibfk_1` (`id_bateau`),
  ADD KEY `bateau_voyageur_equipement_ibfk_2` (`id_equipement`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client_caracteristique`
--
ALTER TABLE `client_caracteristique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_caracteristique_ibfk_2` (`reservation_id`),
  ADD KEY `client_caracteristique_ibfk_3` (`transport_type`);

--
-- Index pour la table `client_reservation`
--
ALTER TABLE `client_reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client` (`client`),
  ADD KEY `traversee` (`traversee`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liaison`
--
ALTER TABLE `liaison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liaison_ibfk_1` (`secteur`),
  ADD KEY `liaison_ibfk_2` (`depart`),
  ADD KEY `liaison_ibfk_3` (`arrivee`);

--
-- Index pour la table `liaison_secteur`
--
ALTER TABLE `liaison_secteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liaison` (`liaison`);

--
-- Index pour la table `periode_transport`
--
ALTER TABLE `periode_transport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_type` (`transport_type`),
  ADD KEY `periode_transport_ibfk_2` (`periode`);

--
-- Index pour la table `port`
--
ALTER TABLE `port`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transport_categorie`
--
ALTER TABLE `transport_categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transport_type`
--
ALTER TABLE `transport_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie` (`categorie`);

--
-- Index pour la table `traversee`
--
ALTER TABLE `traversee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liaison` (`liaison`),
  ADD KEY `bateau` (`bateau`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bateau`
--
ALTER TABLE `bateau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `client_caracteristique`
--
ALTER TABLE `client_caracteristique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `client_reservation`
--
ALTER TABLE `client_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `equipement`
--
ALTER TABLE `equipement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `liaison`
--
ALTER TABLE `liaison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `liaison_secteur`
--
ALTER TABLE `liaison_secteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `periode_transport`
--
ALTER TABLE `periode_transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT pour la table `port`
--
ALTER TABLE `port`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `transport_categorie`
--
ALTER TABLE `transport_categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `transport_type`
--
ALTER TABLE `transport_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `traversee`
--
ALTER TABLE `traversee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bateau_caracteristique`
--
ALTER TABLE `bateau_caracteristique`
  ADD CONSTRAINT `bateau_caracteristique_ibfk_1` FOREIGN KEY (`bateau`) REFERENCES `bateau` (`id`),
  ADD CONSTRAINT `bateau_caracteristique_ibfk_2` FOREIGN KEY (`transport`) REFERENCES `transport_categorie` (`id`);

--
-- Contraintes pour la table `bateau_fret`
--
ALTER TABLE `bateau_fret`
  ADD CONSTRAINT `bateau_fret_ibfk_1` FOREIGN KEY (`id_bateau`) REFERENCES `bateau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bateau_voyageur`
--
ALTER TABLE `bateau_voyageur`
  ADD CONSTRAINT `bateau_voyageur_ibfk_1` FOREIGN KEY (`id_bateau`) REFERENCES `bateau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bateau_voyageur_equipement`
--
ALTER TABLE `bateau_voyageur_equipement`
  ADD CONSTRAINT `bateau_voyageur_equipement_ibfk_1` FOREIGN KEY (`id_bateau`) REFERENCES `bateau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bateau_voyageur_equipement_ibfk_2` FOREIGN KEY (`id_equipement`) REFERENCES `equipement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `client_caracteristique`
--
ALTER TABLE `client_caracteristique`
  ADD CONSTRAINT `client_caracteristique_ibfk_2` FOREIGN KEY (`reservation_id`) REFERENCES `client_reservation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_caracteristique_ibfk_3` FOREIGN KEY (`transport_type`) REFERENCES `transport_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `client_reservation`
--
ALTER TABLE `client_reservation`
  ADD CONSTRAINT `client_reservation_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_reservation_ibfk_2` FOREIGN KEY (`traversee`) REFERENCES `traversee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `liaison`
--
ALTER TABLE `liaison`
  ADD CONSTRAINT `liaison_ibfk_1` FOREIGN KEY (`secteur`) REFERENCES `liaison_secteur` (`id`),
  ADD CONSTRAINT `liaison_ibfk_2` FOREIGN KEY (`depart`) REFERENCES `port` (`id`),
  ADD CONSTRAINT `liaison_ibfk_3` FOREIGN KEY (`arrivee`) REFERENCES `port` (`id`);

--
-- Contraintes pour la table `periode`
--
ALTER TABLE `periode`
  ADD CONSTRAINT `periode_ibfk_1` FOREIGN KEY (`liaison`) REFERENCES `liaison` (`id`);

--
-- Contraintes pour la table `periode_transport`
--
ALTER TABLE `periode_transport`
  ADD CONSTRAINT `periode_transport_ibfk_1` FOREIGN KEY (`transport_type`) REFERENCES `transport_type` (`id`),
  ADD CONSTRAINT `periode_transport_ibfk_2` FOREIGN KEY (`periode`) REFERENCES `periode` (`id`);

--
-- Contraintes pour la table `transport_type`
--
ALTER TABLE `transport_type`
  ADD CONSTRAINT `transport_type_ibfk_1` FOREIGN KEY (`categorie`) REFERENCES `transport_categorie` (`id`);

--
-- Contraintes pour la table `traversee`
--
ALTER TABLE `traversee`
  ADD CONSTRAINT `traversee_ibfk_1` FOREIGN KEY (`liaison`) REFERENCES `liaison` (`id`),
  ADD CONSTRAINT `traversee_ibfk_2` FOREIGN KEY (`bateau`) REFERENCES `bateau` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
