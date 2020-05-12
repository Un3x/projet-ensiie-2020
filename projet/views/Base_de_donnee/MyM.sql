-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 09, 2020 at 03:55 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MyM`
--

-- --------------------------------------------------------

--
-- Table structure for table `Composition`
--

CREATE TABLE `Composition` (
  `id` int(11) NOT NULL,
  `compo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Composition`
--

INSERT INTO `Composition` (`id`, `compo`) VALUES
(1, '4-2-3-1'),
(2, '4-3-3'),
(3, '4-2-4'),
(4, '5-2-2-1'),
(5, '3-4-3');

-- --------------------------------------------------------

--
-- Table structure for table `espace_com_joueur`
--

CREATE TABLE `espace_com_joueur` (
  `id` int(11) NOT NULL,
  `id_joueur` int(11) DEFAULT NULL,
  `id_posteur` int(11) DEFAULT NULL,
  `dateheure_post` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateheure_edition` datetime DEFAULT NULL,
  `contenu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `espace_com_joueur`
--

INSERT INTO `espace_com_joueur` (`id`, `id_joueur`, `id_posteur`, `dateheure_post`, `dateheure_edition`, `contenu`) VALUES
(1, 1, 1, '2020-05-04 20:14:33', NULL, 'Joueur incroyable\r\n'),
(2, 1, 1, '2020-05-04 20:14:36', NULL, 'The GOAT\r\n                    '),
(3, 1, 1, '2020-05-04 20:17:58', NULL, 'Ronlado > Messi                              '),
(4, 1, 1, '2020-05-04 20:18:00', NULL, 'Ronaldo est meilleur'),
(5, 1, 1, '2020-05-04 20:18:02', NULL, 'Team Leo                                                                       '),
(6, 1, 1, '2020-05-04 20:18:04', NULL, 'Barcelona !!!!!'),
(7, 1, 1, '2020-05-04 20:18:05', NULL, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(8, 1, 1, '2020-05-04 20:18:07', NULL, 'com1'),
(9, 1, 1, '2020-05-04 20:18:09', NULL, 'com2'),
(10, 1, 1, '2020-05-04 20:18:14', NULL, 'com3'),
(11, 1, 1, '2020-05-04 20:18:16', NULL, 'com4'),
(12, 1, 1, '2020-05-04 20:18:19', NULL, 'com5'),
(14, 1, 1, '2020-05-04 20:44:38', NULL, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(15, 4, 1, '2020-05-05 13:28:19', NULL, 'Le Bougre est bon'),
(16, 3, 1, '2020-05-05 17:48:39', NULL, 'Le nouveau O Monstro'),
(17, 1, 61, '2020-05-07 21:20:13', NULL, 'Pas Ouf');

-- --------------------------------------------------------

--
-- Table structure for table `espace_com_tactique`
--

CREATE TABLE `espace_com_tactique` (
  `id` int(11) NOT NULL,
  `id_tactique` int(11) DEFAULT NULL,
  `id_posteur` int(11) DEFAULT NULL,
  `dateheure_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateheure_edition` datetime DEFAULT NULL,
  `contenu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `espace_com_tactique`
--

INSERT INTO `espace_com_tactique` (`id`, `id_tactique`, `id_posteur`, `dateheure_post`, `dateheure_edition`, `contenu`) VALUES
(46, 1, 1, '2020-04-28 21:17:34', NULL, 'Super tactique!!\r\n'),
(47, 1, 1, '2020-04-28 21:17:43', NULL, 'Pas fan...'),
(48, 1, 1, '2020-04-28 21:18:14', NULL, 'blablablablablablablablablablablablablablablablablablablablablablablablablablablabla\r\nblablablablablablablablablablablablablablablablablablablablablablablablablablablabla\r\nblablablablablablablablablablablablablablablablablablablablablablablablablablablabla\r\nblablablablablablablablablablablablablablablablablablablablablablablablablablablabla\r\nblablablablablablablablablablablablablablablablablablablablablablablablablablablabla\r\nblablablablablablablablablablablablablablablablablablablablablablablablablablablabla\r\nblablablablablablablablablablablablablablablablablablablablablablablablablablablabla'),
(50, 2, 2, '2020-04-28 21:20:30', NULL, 'OK\r\n'),
(52, 1, 2, '2020-04-29 15:21:57', NULL, 'Incroyable'),
(58, 3, 1, '2020-04-30 13:57:55', NULL, 'Trop fort\r\n'),
(60, 3, 1, '2020-04-30 13:59:28', NULL, 'Best equipe'),
(62, 26, 1, '2020-04-30 16:05:24', NULL, 'J\'ai réussi!!\r\n'),
(64, 1, 1, '2020-04-30 16:27:45', NULL, '                                            com'),
(65, 1, 1, '2020-04-30 16:27:51', NULL, 'com2      '),
(66, 1, 1, '2020-04-30 16:28:02', NULL, '                        com3'),
(67, 1, 1, '2020-04-30 16:28:08', NULL, 'com4        '),
(68, 1, 1, '2020-04-30 16:28:21', NULL, 'com5'),
(69, 1, 1, '2020-04-30 16:28:42', NULL, 'com6'),
(70, 1, 1, '2020-04-30 16:28:54', NULL, 'com7 '),
(71, 1, 1, '2020-04-30 16:32:41', NULL, 'Voilaaa!!!'),
(72, 1, 1, '2020-04-30 16:56:06', NULL, '                                            eee'),
(73, 27, 1, '2020-04-30 17:01:21', NULL, '                                            AIE...'),
(74, 7, 1, '2020-05-04 17:14:08', NULL, 'Ahahahhha tu fais aucun effort tas jouer 2h...'),
(75, 1, 1, '2020-05-06 20:48:10', NULL, 'ok'),
(76, 3, 1, '2020-05-07 02:11:57', NULL, 'WOW!!'),
(77, 61, 1, '2020-05-07 15:17:54', NULL, 'Incroyable\r\n'),
(78, 1, 61, '2020-05-07 21:21:11', NULL, 'Best teammm!!!!!'),
(79, 26, 61, '2020-05-07 21:21:31', NULL, 'Bien joué'),
(80, 64, 1, '2020-05-08 20:03:51', NULL, 'WOWWWW'),
(81, 64, 1, '2020-05-08 20:04:09', NULL, 'WOWWWW'),
(82, 66, 61, '2020-05-09 16:28:50', NULL, 'incroyable!'),
(83, 66, 61, '2020-05-09 16:29:12', NULL, 'Ou est Van Djik?');

-- --------------------------------------------------------

--
-- Table structure for table `f_categories`
--

CREATE TABLE `f_categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `f_categories`
--

INSERT INTO `f_categories` (`id`, `nom`) VALUES
(1, 'Football Manager 2020'),
(2, 'Football Manager 2021'),
(3, 'Football'),
(4, 'Annonces');

-- --------------------------------------------------------

--
-- Table structure for table `f_messages`
--

CREATE TABLE `f_messages` (
  `id` int(11) NOT NULL,
  `id_topic` int(11) DEFAULT NULL,
  `id_posteur` int(11) NOT NULL,
  `dateheure_post` datetime NOT NULL,
  `dateheure_edition` datetime DEFAULT CURRENT_TIMESTAMP,
  `meilleur_reponse` tinyint(1) DEFAULT '0',
  `contenu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `f_messages`
--

INSERT INTO `f_messages` (`id`, `id_topic`, `id_posteur`, `dateheure_post`, `dateheure_edition`, `meilleur_reponse`, `contenu`) VALUES
(1, 12, 1, '2020-04-17 12:58:01', '2020-04-17 12:58:01', 0, 'Oh mais c\'est trop gentil de ta part merci ! '),
(8, 12, 1, '2020-04-18 13:04:40', '2020-04-18 13:04:40', 0, 'Ah... tu t\'es fait virer... On fait comment maintenant'),
(9, 12, 2, '2020-04-18 13:04:40', '2020-04-18 13:04:40', 0, 'Euhhhhhhh...'),
(10, 12, 3, '2020-04-18 13:05:46', '2020-04-18 13:05:46', 0, 'La racaille s\'en va !'),
(11, 12, 4, '2020-04-18 13:05:46', '2020-04-18 13:05:46', 0, 'YOUPI'),
(14, 12, 1, '2020-04-18 12:58:01', '2020-04-18 13:09:53', 0, 'OK'),
(15, 12, 2, '2020-04-18 13:09:53', '2020-04-18 13:09:53', 0, 'Bon...'),
(19, 11, 1, '2020-04-18 14:36:01', NULL, NULL, 'Nom : Karunanayakage\r\nPrénom : Shamal\r\nPseudo : Karu\r\nChampionnat : Première Ligue\r\nEquipe : Arsenal\r\nAutorisation de diffusion: oui                                         '),
(20, 11, 2, '2020-04-18 14:37:58', NULL, NULL, 'Trop cool ! \r\nNom : Lachat, Prénom : Gabin, Pseudo : Gabinho, Championnat : Première Ligue, Equipe : Manchester City, Autorisation de diffusion: oui.'),
(21, 11, 3, '2020-04-18 14:39:39', NULL, NULL, '                                            	Mouai pas convaincu mais bon allons y ! Nom : Bougrine, Prénom : Rayan, Pseudo : RB9, Championnat : Première Ligue, Equipe : Liverpool, Autorisation de diffusion: oui.'),
(25, 11, 4, '2020-04-18 15:04:46', '2020-04-18 15:04:46', 0, '                                            Flemme hein... '),
(26, 13, 3, '2020-04-18 15:06:37', '2020-04-18 15:06:37', 0, '                                            Achete Tammy Abraham! Trop fort ce joueur !!'),
(27, 12, 1, '2020-04-28 17:40:41', '2020-04-28 17:40:41', 0, '                                            Incroyable\r\n'),
(28, 11, 1, '2020-04-30 14:01:06', '2020-04-30 14:01:06', 0, 'Ca commence quand?\r\n'),
(29, 11, 1, '2020-04-30 14:01:59', '2020-04-30 14:01:59', 0, 'Ca commence quand?\r\n'),
(30, 2, 2, '2020-04-30 14:03:07', '2020-04-30 14:03:07', 0, 'Trop cool, je veux venir'),
(31, 12, 1, '2020-04-30 16:23:25', '2020-04-30 16:23:25', 0, '                                            com'),
(32, 12, 1, '2020-04-30 16:23:31', '2020-04-30 16:23:31', 0, '                                            com 2'),
(33, 12, 1, '2020-04-30 16:23:40', '2020-04-30 16:23:40', 0, '                                            com 3'),
(34, 12, 1, '2020-04-30 16:23:51', '2020-04-30 16:23:51', 0, '                                            on est a la page 2'),
(35, 13, 61, '2020-05-07 21:20:53', '2020-05-07 21:20:53', 0, 'Lautaro Martinez quel crack'),
(36, 13, 62, '2020-05-08 21:20:15', '2020-05-08 21:20:15', 0, 'blablabbla\r\n                                            ');

-- --------------------------------------------------------

--
-- Table structure for table `f_souscategories`
--

CREATE TABLE `f_souscategories` (
  `id` int(11) NOT NULL,
  `id_cate` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `f_souscategories`
--

INSERT INTO `f_souscategories` (`id`, `id_cate`, `nom`) VALUES
(1, 1, 'Discussion générale'),
(2, 1, 'Conseil Tactique'),
(3, 1, 'Conseil Joueur'),
(4, 1, 'Rejoindre un serveur'),
(5, 1, 'Créer un serveur'),
(6, 2, 'Discussion générale'),
(7, 2, 'Infos'),
(11, 3, 'Infos'),
(12, 3, 'Equipes'),
(13, 3, 'Joueurs'),
(14, 1, 'Tournoi'),
(15, 3, 'Transfert'),
(16, 3, 'Entraineur'),
(17, 3, 'Supporters'),
(18, 4, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `f_topics`
--

CREATE TABLE `f_topics` (
  `id` int(11) NOT NULL,
  `id_createur` int(11) DEFAULT NULL,
  `sujet` text,
  `contenu` text,
  `dateheure_creat` datetime DEFAULT NULL,
  `resolu` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `f_topics`
--

INSERT INTO `f_topics` (`id`, `id_createur`, `sujet`, `contenu`, `dateheure_creat`, `resolu`) VALUES
(1, 1, 'Meilleur Jeu de tous les temps', 'Selon vous est ce le meilleur jeu de tous les temps', '2020-04-14 19:51:15', NULL),
(2, 1, 'Le plus grands serveur ', 'Rejoins mon serveur FM pour un max de plaisir', '2020-04-01 15:54:25', NULL),
(3, 3, 'Devenir une LEGENDE', 'Comment faire des saisons à la Bougrine, légende de FM ?', '2020-04-15 13:30:17', NULL),
(4, 2, 'Le topic pour pouvoir être financé par un état ', 'Voici comment être financé par un état et pour avoir un budget transfert ridiculement élevé, et pour pouvoir acheter des jeunes joueurs qui entraineront ma perte!', '2020-04-14 13:49:17', NULL),
(5, 1, 'Idées sur le nouveaux FM2021', 'Qu\'espérez-vous du nouveau Football Manager 2021 qui sortira en fin d\'année?', '2020-04-14 14:25:01', NULL),
(6, 2, 'FM2021 Date de sorie?', 'Quand sortiras le nouveau Football Manager 2021?', '2020-04-14 14:25:01', NULL),
(7, 3, 'Déléguer à son adjoint', 'Comment déléguer à son adjoint les choses ennuyantes de FM?', '2020-04-14 20:30:48', NULL),
(8, 1, 'Besoin d\'un joueur', 'Je cherche un bon défenseur central entre 19 et 23 ans, avec le potentiel pour devenir titulaire à Arsenal dans 1 saison.', '2020-04-08 20:36:57', NULL),
(9, 2, 'Retour de la Ligue des Champions ', 'Quelqu\'un à des informations sur la reprise de Ligue des Champions? J\'en peux plus!', '2020-03-05 20:40:19', NULL),
(10, 2, 'Ballon D\'Or 2020', 'Qui va gagner le Ballon d\'Or 2020 à votre avis.', '2020-04-10 20:45:04', NULL),
(11, 1, 'Premier grand tournoi sur FM2020 ouverte à tous!', 'J\'organise le tout premier tournoi sur FM2020! \r\nSi tu veux participer envoies une réponse sur ce topic avec nom, prénom, pseudo, le championnat et l\'équipe que tu souhaites jouer, une autorisation de diffusion pour le suivi du tournoi pour les viewers!\r\nLes règles du tournoi seront communiqué ultérieurement !', '2020-04-17 15:01:01', NULL),
(12, 2, '4-2-3-1 en tiki-taka : Meilleur dispositif de FM', 'Le meilleur dispositif de FM, est bien sur le 4-2-3-1, avec un 10 qui distribue des caviars. \r\nPersonnellement je joue avec Man United et j\'ai acheter Aouar qui peut potentiellement devenir le meilleur joueur de FM, avec derriere lui un petit jeune incroyable Hannibal Mejbri mais que je vais surement devoir vendre à Arsenal!', '2020-04-17 15:08:54', NULL),
(13, 1, 'J\'ai besoin d\'un attaquant expérimenté svp', 'J\'ai besoin de vous ! Proposez en masse, je choisirais le 12 mai', '2020-04-17 16:13:32', NULL),
(17, 1, 'Les meilleurs supporters', 'Les Gunners sont les meilleurs!!! LET\'S GO GUNNERSSSSSS', '2020-04-17 16:23:37', NULL),
(18, 1, 'Mise en ligne imminente du nouveau site ', 'Le site final arrive dans quelques jours, tenez vous prêt fan de FM, venez partager votre équipe, rechercher un joueur ou encore discuter de tout ou de rien avec le reste de la communauté.', '2020-04-19 02:33:54', NULL),
(19, 1, 'Nos reseaux sociaux', 'Venez nous suivre sur...', '2020-05-06 21:04:08', NULL),
(20, 1, 'Bonjour', 'zde efd', '2020-05-06 22:27:13', NULL),
(21, 1, 'dfc ', 'ssss', '2020-05-06 22:28:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `f_topicscate`
--

CREATE TABLE `f_topicscate` (
  `id_topicscate` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL,
  `id_cate` int(11) NOT NULL,
  `id_souscate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `f_topicscate`
--

INSERT INTO `f_topicscate` (`id_topicscate`, `id_topic`, `id_cate`, `id_souscate`) VALUES
(1, 1, 1, 1),
(2, 3, 1, 2),
(3, 5, 2, 6),
(4, 6, 2, 7),
(5, 2, 1, 4),
(6, 4, 1, 1),
(7, 8, 1, 3),
(9, 9, 3, 11),
(10, 10, 3, 12),
(11, 11, 1, 14),
(12, 12, 1, 2),
(13, 13, 1, 3),
(14, 14, 1, 3),
(15, 15, 1, 3),
(16, 16, 1, 3),
(17, 17, 3, 17),
(18, 18, 4, 18),
(19, 19, 4, 18),
(20, 20, 3, 16),
(21, 21, 3, 16);

-- --------------------------------------------------------

--
-- Table structure for table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `nation_id` int(11) DEFAULT NULL,
  `poste` varchar(255) DEFAULT NULL,
  `attaque` int(11) DEFAULT NULL,
  `defense` int(11) DEFAULT NULL,
  `technique` int(11) NOT NULL DEFAULT '0',
  `note` float DEFAULT '0',
  `valeur` float DEFAULT NULL,
  `note_utilisateur` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `joueurs`
--

INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `age`, `nation_id`, `poste`, `attaque`, `defense`, `technique`, `note`, `valeur`, `note_utilisateur`) VALUES
(1, 'Messi', 'Lionel', 32, 10, 'ATT', 20, 11, 18, 4.5, 120, 0),
(2, 'Ronaldo', 'Cristiano', 35, 9, 'ATT', 20, 12, 17, 4.5, 120, 0),
(3, 'Mbappé', 'Kylian', 21, 2, 'ATT', 18, 10, 18, 4.5, 180, 0),
(4, 'Marquinhos', '', 25, 13, 'DEF', 9, 17, 9, 75, 4.5, 0),
(5, 'Milinkovic-Savic', 'Sergej', 25, 11, 'ML', 13, 16, 14, 4, 65, 0),
(6, 'Bennacer', 'Ismael', 22, 15, 'ML', 14, 14, 13, 3, 45, 0),
(7, 'Silva', 'Bernardo', 25, 9, 'ML', 17, 14, 16, 4, 91, 0),
(8, 'Varane', 'Raphael', 2, 2, 'DEF', 13, 19, 11, 4, 95, 0),
(9, 'Ramos', 'Yannick\r\n', 16, 7, 'ML', 12, 12, 16, 4, 21, 0),
(10, 'Ter Stegen', 'Marc-Andre', 28, 6, 'GK', 3, 18, 6, 3.5, 69, 0),
(11, 'Pogba', 'Paul', 27, 2, 'ML', 14, 15, 15, 4, 100, 0),
(12, 'Tierney', 'Kieran', 22, 12, 'DEF', 12, 15, 11, 3.5, 45, 0),
(13, 'Alexander-Arnold', 'Trent', 21, 4, 'DEF', 13, 14, 10, 3.5, 50, 0),
(14, 'Van Dijk', 'Virgil', 28, 7, 'DEF', 10, 19, 8, 4.5, 95, 0),
(15, 'Donnarumma', 'Gianluigi', 21, 14, 'GK', 5, 19, 6, 4.5, 83, 0),
(16, 'Kessie', 'Franck', 23, 16, 'ML', 14, 17, 13, 3, 35, 0),
(17, 'Gonzales', 'Marc', 16, 8, 'ATT', 18, 13, 16, 2, 33, 0),
(18, 'Haaland', 'Erling', 19, 17, 'ATT', 18, 7, 14, 3.5, 69, 0),
(21, 'Karu', 'Sha', 21, 1, 'ATT', 20, 20, 12, 5, 100, 0),
(22, 'Lach', 'Gabs', 20, 2, 'GK', 7, 20, 12, 4, 100, 0),
(23, 'Bougre', 'Rayan', 21, 3, 'ML', 20, 3, 18, 4, 100, 0),
(24, 'Aka', 'Sam', 20, 3, 'DEF', 15, 15, 5, 4, 120, 0),
(36, 'Bernd', 'Leno', 28, 6, 'GK', 3, 17, 5, 3, 35, 0),
(37, 'Kana', 'Marco', 17, 18, 'DEF', 13, 14, 13, 2.5, 24, 0),
(38, 'Bellerin', 'Hector', 25, 8, 'DEF', 13, 16, 13, 4, 65, 0),
(39, 'Sancho', 'Jadon', 20, 4, 'ATT', 20, 12, 16, 5, 135, 0),
(40, 'Rafa', 'Silva', 26, 9, 'ATT', 16, 14, 14, 4, 66, 0),
(41, 'Martinez', 'Lautaro', 22, 10, 'ATT', 19, 12, 16, 4, 99, 0),
(42, 'Abraham', 'Tammy', 22, 4, 'ATT', 17, 14, 15, 3, 77, 0);

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `Prenom` varchar(255) DEFAULT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `club` text,
  `Version` varchar(255) DEFAULT NULL,
  `motdepasse` text NOT NULL,
  `m_admin` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id`, `Nom`, `Prenom`, `pseudo`, `mail`, `club`, `Version`, `motdepasse`, `m_admin`) VALUES
(4, 'Akarioh', 'Samir', 'Samir', 'admin4@gmail.com', 'Chelsea', 'FM2020', 'a81b4cdc7ceaaa6ab73f75907d9eed33ebdf6b0b', 1),
(19, NULL, NULL, 'utilisateur1', 'utilisateur1@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(3, 'Bougrine', 'Rayan', 'Rayan', 'admin3@gmail.com', 'OL', 'FM2020', 'a81b4cdc7ceaaa6ab73f75907d9eed33ebdf6b0b', 1),
(2, 'Lachat', 'Gabin', 'Gabin', 'admin2@gmail.com', 'PSG', 'FM2020', 'a81b4cdc7ceaaa6ab73f75907d9eed33ebdf6b0b', 1),
(1, 'Karunanayakage', 'Shamal', 'Shamal', 'admin@gmail.com', 'OL', 'FM2020', 'a81b4cdc7ceaaa6ab73f75907d9eed33ebdf6b0b', 1),
(17, NULL, NULL, 'ff', 'aaaa@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(20, NULL, NULL, 'utilisateur2', 'utilisateur2@gmail.com', NULL, NULL, '70c881d4a26984ddce795f6f71817c9cf4480e79', 0),
(22, NULL, NULL, 'utilisateur3', 'utilisateur3@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(23, NULL, NULL, 'utilisateur4', 'utilisateur4@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(24, NULL, NULL, 'utilisateur5', 'utilisateur5@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(25, NULL, NULL, 'utilisateur6', 'utilisateur6@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(32, NULL, NULL, 'azerty', 'azerty@azerty.fr', NULL, NULL, 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 0),
(39, NULL, NULL, 'utilisateur7', 'utilisateur7@gmail.com', NULL, NULL, '9cf95dacd226dcf43da376cdb6cbba7035218921', 0),
(40, NULL, NULL, 'utilisateur8', 'utilisateur8@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(41, NULL, NULL, 'utilisateur9', 'utilisateur9@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(42, NULL, NULL, 'utilisateur10', 'utilisateur10@gmail.com', NULL, NULL, '782dd27ea8e3b4f4095ffa38eeb4d20b59069077', 0),
(43, NULL, NULL, 'utilisateur11', 'utilisateur11@gmail.com', NULL, NULL, '36a32e96cbfd11fd98e8c98e38d9ad9b41f57f1a', 0),
(44, NULL, NULL, 'utilisateur12', 'utilisateur12@gmail.com', NULL, NULL, '7e240de74fb1ed08fa08d38063f6a6a91462a815', 0),
(45, NULL, NULL, 'utilisateur13', 'utilisateur13@gmail.com', NULL, NULL, 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 0),
(46, NULL, NULL, 'utilisateur14', 'utilisateur14@gmail.com', NULL, NULL, '18bcf0cc3d484fd5d97e97af16cd85bdba1d01a4', 0),
(47, NULL, NULL, 'utilisateur15', 'utilisateur15@gmail.com', NULL, NULL, '5aad7c4881178b80be41a6880c2a49642057f7cb', 0),
(62, 'azerty', 'azerty', 'azerty', 'azerty@ensiie.fr', 'FC ENSIIE', 'FM2020', '9cf95dacd226dcf43da376cdb6cbba7035218921', 0),
(61, 'Karu', 'Sha', 'KaruS', 'user1@gmail.com', 'FC Barcelone', 'FM 2020', 'a81b4cdc7ceaaa6ab73f75907d9eed33ebdf6b0b', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nation`
--

CREATE TABLE `nation` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nation`
--

INSERT INTO `nation` (`id`, `nom`) VALUES
(1, 'Sri Lanka'),
(2, 'France'),
(3, 'Maroc'),
(4, 'Angleterre'),
(5, 'USA'),
(6, 'Allemagne'),
(7, 'Pays Bas'),
(8, 'Espagne'),
(9, 'Portugal'),
(10, 'Argentine'),
(11, 'Serbie'),
(12, 'Ecosse'),
(13, 'Bresil'),
(14, 'Italie'),
(15, 'Algerie'),
(16, 'Cote d\'Ivoire'),
(17, 'Norvege'),
(18, 'Belgique');

-- --------------------------------------------------------

--
-- Table structure for table `tactique`
--

CREATE TABLE `tactique` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `id_membre` int(11) DEFAULT NULL,
  `equipe` varchar(255) DEFAULT NULL,
  `composition` int(11) DEFAULT NULL,
  `commentaire` text,
  `dateheure_creat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `joueur1` varchar(255) DEFAULT NULL,
  `joueur2` varchar(255) DEFAULT NULL,
  `joueur3` varchar(255) DEFAULT NULL,
  `joueur4` varchar(255) DEFAULT NULL,
  `joueur5` varchar(255) DEFAULT NULL,
  `joueur6` varchar(255) DEFAULT NULL,
  `joueur7` varchar(255) DEFAULT NULL,
  `joueur8` varchar(255) DEFAULT NULL,
  `joueur9` varchar(255) DEFAULT NULL,
  `joueur10` varchar(255) DEFAULT NULL,
  `joueur11` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tactique`
--

INSERT INTO `tactique` (`id`, `nom`, `id_membre`, `equipe`, `composition`, `commentaire`, `dateheure_creat`, `joueur1`, `joueur2`, `joueur3`, `joueur4`, `joueur5`, `joueur6`, `joueur7`, `joueur8`, `joueur9`, `joueur10`, `joueur11`) VALUES
(1, 'best', 1, 'Arsenal', 3, 'Voici l\'une des meilleurs équipes de Première Ligue.', '2020-05-07 15:16:37', 'Bernd Leno', 'Kieran Tierney', 'Marco Kana ', 'Raphael Varane\r\n', 'Hector Bellerin', 'Yannick Ramos', 'Ismael Bennacer', 'Jadon Sancho', 'Lautaro Martinez', 'Tammy Abraham', 'Silva Rafa'),
(2, 'money', 2, 'Manchester City', 1, 'zzz', '2020-04-29 12:48:32', 'Lach Gabs', 'Aka Sam', 'joueur2 Quentin', 'Bougre Rayan', 'Karu Shamal', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Champion mon frère', 3, 'Liverpool', 2, NULL, '2020-04-29 12:48:32', 'Lach Gabs', 'Aka Sam', 'joueur2 Quentin', 'Bougre Rayan', 'Karu Shamal', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'tactiques 2 match', 4, 'Chelsea', 1, 'Le sapin de Samir pour 2 match', '2020-04-30 13:31:46', 'Lach Gabs', 'Aka Sam', 'joueur2 Quentin', 'Bougre Rayan', 'Karu Shamal', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Ma tactique', 61, 'FC Equipe', 1, 'Je vous présente ma tactique', '2020-05-09 13:11:14', 'Lach Gabs', 'Tierney Kieran', 'Aka Sam', 'Varane Raphael', 'Alexander-Arnold Trent', 'Milinkovic-Savic Sergej', 'Ramos Yannick\r\n', 'Bougre Rayan', 'Karu Sha', 'Sancho Jadon', 'Silva Bernardo'),
(15, 'RSG Dream Team', 1, 'FC RSG', 2, 'La dream team des équipes de Rayan, Gabin et Shamal.', '2020-05-09 12:27:43', 'Donnarumma Gianluigi', 'Tierney Kieran', 'Van Dijk Virgil', 'Marquinhos ', 'Alexander-Arnold Trent', 'Milinkovic-Savic Sergej', 'Ramos Yannick\r\n', 'Kessie Franck', 'Haaland Erling', 'Gonzales Marc', 'Silva Bernardo'),
(27, 'de Norwich au chômage', 2, 'Norwich', 4, 'Comment ma carrière a tourné au vinaigre ', '2020-04-30 17:00:56', 'Lach Gabs', 'Aka Sam', 'joueur2 Quentin', 'Bougre Rayan', 'Karu Shamal', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'ENSIIE', 1, 'FC ENSIIE', 3, 'La fine équipe', '2020-04-29 12:48:32', 'Lach Gabs', 'Aka Sam', 'Lach Gabs', 'Aka Sam', 'Aka Sam', 'Bougre Rayan', 'Lach Gabs', 'Bougre Rayan', 'Lach Gabs', 'Karu Shamal', 'Karu Shamal'),
(65, 'azerty', 2, 'azerty', 1, 'azertyazertyu azertyujx', '2020-05-08 20:06:10', 'Lach Gabs', 'Aka Sam', 'Aka Sam', 'Aka Sam', 'Aka Sam', 'Bougre Rayan', 'Bougre Rayan', 'Bougre Rayan', 'Karu Sha', 'Karu Sha', 'Karu Sha'),
(66, 'azertyu', 61, 'FC azertyu', 2, 'azertyuazertyu azertyu', '2020-05-09 16:27:41', 'Marc-Andre Ter Stegen', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Composition`
--
ALTER TABLE `Composition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `espace_com_joueur`
--
ALTER TABLE `espace_com_joueur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `espace_com_tactique`
--
ALTER TABLE `espace_com_tactique`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_categories`
--
ALTER TABLE `f_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_messages`
--
ALTER TABLE `f_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_souscategories`
--
ALTER TABLE `f_souscategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_topics`
--
ALTER TABLE `f_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_topicscate`
--
ALTER TABLE `f_topicscate`
  ADD PRIMARY KEY (`id_topicscate`);

--
-- Indexes for table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nation`
--
ALTER TABLE `nation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tactique`
--
ALTER TABLE `tactique`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Composition`
--
ALTER TABLE `Composition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `espace_com_joueur`
--
ALTER TABLE `espace_com_joueur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `espace_com_tactique`
--
ALTER TABLE `espace_com_tactique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `f_categories`
--
ALTER TABLE `f_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `f_messages`
--
ALTER TABLE `f_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `f_souscategories`
--
ALTER TABLE `f_souscategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `f_topics`
--
ALTER TABLE `f_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `f_topicscate`
--
ALTER TABLE `f_topicscate`
  MODIFY `id_topicscate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `nation`
--
ALTER TABLE `nation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tactique`
--
ALTER TABLE `tactique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
