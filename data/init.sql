-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2020 at 09:23 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stiime`
--

-- --------------------------------------------------------

--
-- Table structure for table `ban`
--

CREATE TABLE `ban` (
  `user` int(10) UNSIGNED NOT NULL,
  `end` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ban`
--

INSERT INTO `ban` (`user`, `end`) VALUES
(3, '2020-04-05 20:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `user_from` int(10) UNSIGNED NOT NULL,
  `user_to` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`user_from`, `user_to`) VALUES
(1, 2),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `abrev` varchar(5) NOT NULL,
  `fullname` varchar(64) NOT NULL,
  `description` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`abrev`, `fullname`, `description`) VALUES
('chess', 'Lichess', 'Lichess est un site libre, open-source et non commercial. Il permet de jouer aux modes de jeu classiques, mais aussi d\'autres plus fun, des guides, l\'analyse par Stockfish, des problèmes. C\'est le deuxième site d\'échecs le plus fréquenté au monde, avec plus d\'un million de parties jouées par jour.'),
('csgo', 'Counter-Strike: Global Offensive', 'Ancien mod de Half-Life destiné au multijoueur, Counter-Strike : Global offensive est un jeu de tir à la première personne. Les joueurs y choisissent le camp des terroristes ou des anti-terroristes avant de s\'affronter dans des batailles sans merci. Plusieurs modes de jeux sont disponibles (dont un d\'entraînement) et les combattants ont accès à plus de trente armes différentes.'),
('lol', 'League of Legends', 'Inspiré du mod DotA de Warcraft III, League of Legends est un MOBA, une arène de bataille en ligne multijoueur. Dans le mode classique, deux équipes de cinq joueurs s\'affrontent dans des parties qui durent en moyenne entre 40 minutes et dont l\'objectif est de détruire la base ennemie. Évoluant dans un univers heroic-fantasy, chaque joueur incarne un champion différent, aux capacités uniques, qu\'il choisit à chaque début de partie.'),
('osu', 'osu!', 'osu! est un jeu de rythme en ligne gratuit dont le gameplay est grandement inspiré d\'autres titres célèbres du même genre. Le jeu permet une grande personnalisation ainsi que des classements en ligne et une communauté active.'),
('valor', 'Valorant', 'Valorant, anciennement Project A, est un FPS tactique dans la veine de Counter Strike et de Team Fortress. Le jeu développé et édité par Riot Games proposera de nombreux personnages aux capacités uniques, différents modes de jeu et promet déjà des serveurs sans failles et un système anti-triche à la pointe de la technologie.');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genre` varchar(31) NOT NULL,
  `game` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genre`, `game`) VALUES
('FPS', 'csgo'),
('FPS', 'valor'),
('Jeu de rythme', 'osu'),
('MOBA', 'lol'),
('Stratégie', 'chess'),
('Stratégie', 'csgo'),
('Stratégie', 'valor');

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE `hashtag` (
  `hashtag` varchar(31) NOT NULL,
  `message` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`hashtag`, `message`) VALUES
('chess', 3),
('lichess', 6);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `content` tinytext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `visibility` enum('public','unlisted','private','deleted') NOT NULL DEFAULT 'public',
  `type` enum('post','review','','') NOT NULL DEFAULT 'post',
  `reply` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user`, `content`, `created_at`, `visibility`, `type`, `reply`) VALUES
(1, 1, 'Hello World', '2020-04-04 22:00:00', 'public', 'post', NULL),
(2, 2, 'Hello Admin!', '2020-04-04 22:00:00', 'public', 'post', 1),
(3, 1, 'J\'adore jouer à #chess', '2020-04-05 19:12:28', 'unlisted', 'post', NULL),
(4, 3, 'Je me suis fait supprimer :(', '2020-04-05 19:13:13', 'deleted', 'post', 3),
(5, 2, 'Réponse à un message supprimé', '2020-04-05 19:14:00', 'unlisted', 'post', 4),
(6, 2, 'Petite review de Lichess #lichess', '2020-04-05 19:14:28', 'public', 'review', NULL),
(7, 2, 'Je suis un message privé : seuls mes relations mutuelles peuvent me voir!', '2020-04-05 19:15:22', 'private', 'post', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `reaction` (
  `emoji` char(2) NOT NULL DEFAULT '❤️',
  `user` int(10) UNSIGNED NOT NULL,
  `message` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reaction`
--

INSERT INTO `reaction` (`emoji`, `user`, `message`) VALUES
('♟️', 3, 3),
('❤️', 1, 1),
('❤️', 3, 1),
('🔁', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(60) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','mod','member','') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(1, 'admin', '$2y$10$qGPw0DfDrtP1RXEtWvWmGuxGrxozbqyFCaWH8iCbIPLX7SfHpfq.u', '0000-00-00 00:00:00', 'admin'),
(2, 'mod', '$2y$10$1Jh8G9g4iJj.wZ0AFJLj5eoDn6V1aTO3vLdCPAUgHsgrdSZVpGYUi', '0000-00-00 00:00:00', 'mod'),
(3, 'member', '$2y$10$XuehT4QEYcPeVgU6Jv4W4emPltOaFfUkDFzqNupebJdZtz40yD9Q6', '0000-00-00 00:00:00', 'member'),
(4, 'test', '$2y$10$oYgTTR9fMFTNENp.KfgEfeaeisXrAt6FNFnVfpRtN/mCX9tI9rFna', '2020-04-07 09:09:48', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `user_game`
--

CREATE TABLE `user_game` (
  `pseudo` varchar(63) NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `game` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_game`
--

INSERT INTO `user_game` (`pseudo`, `user`, `game`) VALUES
('MagnusCarlsen', 1, 'chess'),
('Blitzstream', 3, 'chess'),
('Skyyart', 1, 'lol');

-- --------------------------------------------------------

--
-- Table structure for table `user_vote`
--

CREATE TABLE `user_vote` (
  `vote` tinyint(1) NOT NULL DEFAULT 1,
  `user` int(10) UNSIGNED NOT NULL,
  `game` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_vote`
--

INSERT INTO `user_vote` (`vote`, `user`, `game`) VALUES
(1, 1, 'chess'),
(1, 2, 'chess'),
(0, 3, 'chess'),
(1, 3, 'valor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ban`
--
ALTER TABLE `ban`
  ADD UNIQUE KEY `user` (`user`,`end`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD UNIQUE KEY `user_from` (`user_from`,`user_to`),
  ADD KEY `fk_follow_user_to` (`user_to`),
  ADD KEY `fk_follow_user_from` (`user_from`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`abrev`),
  ADD UNIQUE KEY `fullname` (`fullname`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD UNIQUE KEY `genre` (`genre`,`game`),
  ADD KEY `fk_genre_game` (`game`);

--
-- Indexes for table `hashtag`
--
ALTER TABLE `hashtag`
  ADD UNIQUE KEY `hashtag` (`hashtag`,`message`),
  ADD KEY `fk_hashtag_message` (`message`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_message_reply` (`reply`),
  ADD KEY `fk_message_user` (`user`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `reaction`
  ADD UNIQUE KEY `emoji` (`emoji`,`user`,`message`),
  ADD KEY `fk_reaction_message` (`message`),
  ADD KEY `fk_reaction_user` (`user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_game`
--
ALTER TABLE `user_game`
  ADD KEY `fk_user_game_user` (`user`),
  ADD KEY `fk_user_game_game` (`game`);

--
-- Indexes for table `user_vote`
--
ALTER TABLE `user_vote`
  ADD UNIQUE KEY `user` (`user`,`game`),
  ADD KEY `fk_user_vote_game` (`game`),
  ADD KEY `fk_user_vote_user` (`user`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `fk_ban_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `fk_follow_user_from` FOREIGN KEY (`user_from`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_follow_user_to` FOREIGN KEY (`user_to`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `genre`
--
ALTER TABLE `genre`
  ADD CONSTRAINT `fk_genre_game` FOREIGN KEY (`game`) REFERENCES `game` (`abrev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hashtag`
--
ALTER TABLE `hashtag`
  ADD CONSTRAINT `fk_hashtag_message` FOREIGN KEY (`message`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_reply` FOREIGN KEY (`reply`) REFERENCES `message` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `fk_reaction_message` FOREIGN KEY (`message`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reaction_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_game`
--
ALTER TABLE `user_game`
  ADD CONSTRAINT `fk_user_game_game` FOREIGN KEY (`game`) REFERENCES `game` (`abrev`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_game_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_vote`
--
ALTER TABLE `user_vote`
  ADD CONSTRAINT `fk_user_vote_game` FOREIGN KEY (`game`) REFERENCES `game` (`abrev`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_vote_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
