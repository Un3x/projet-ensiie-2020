-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 09 mai 2020 à 17:24
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `DB`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id_event` int(11) NOT NULL,
  `nom_event` varchar(255) NOT NULL,
  `lieu_event` varchar(255) NOT NULL,
  `date_event` datetime NOT NULL,
  `respo_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id_event`, `nom_event`, `lieu_event`, `date_event`, `respo_event`) VALUES
(14, 'Noël 2020', 'Paris', '2020-12-24 23:59:59', 23);

-- --------------------------------------------------------

--
-- Structure de la table `incomers`
--

CREATE TABLE `incomers` (
  `id` int(11) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `incomers`
--

INSERT INTO `incomers` (`id`, `id_event`) VALUES
(21, 14),
(23, 14),
(24, 14),
(25, 14);

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`id`, `id_projet`) VALUES
(21, 7),
(21, 8),
(23, 8);

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id_projet` int(11) NOT NULL,
  `nom_projet` varchar(255) NOT NULL,
  `nom_client` varchar(255) NOT NULL,
  `nom_chef_de_projet` varchar(255) NOT NULL,
  `echeance` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id_projet`, `nom_projet`, `nom_client`, `nom_chef_de_projet`, `echeance`) VALUES
(7, 'Projet de Kamisama', 'Toto', 'Kamisama', '2020-06-08 16:00:00'),
(8, 'Projet de Babar', 'Cola', 'Babar', '2020-06-08 16:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp(),
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `telephone`, `pseudo`, `mot_de_passe`, `date_inscription`, `admin`) VALUES
(21, 'Nadjar', 'Antoine', 'antoine.nadjar@hotmail.fr', '0669744580', 'Babar', '$2y$10$yiTS9RdUl1WSLA3dcpR7k.QVpejTfN24J0qbUs7/cx5Os5vNrV3nW', '2020-05-05 23:37:46', 1),
(23, 'Alfred', 'Romain', 'romain.alfred@gmail.com', '0612564376', 'Kamisama', '$2y$10$TO6FlYHUkG8mk9Y2/jAeYuvhdc8qmdf/P30nBmLUhm6oD77JvlqUi', '2020-05-07 02:53:44', 0),
(24, 'Mazet', 'Paul', 'paul.mazet@gmail.com', '0622346112', 'King', '$2y$10$oG6PKxwwyh3pIlCelmNxHeTedleiORAzKZqliLS2VZ4esYldi53su', '2020-05-09 15:48:08', 0),
(25, 'Ba', 'Amadou', 'amadou.ba@gmail.com', '0657428619', 'Ba', '$2y$10$wVbwURaxRe7NRlw0rDeFmuaT4cv7cQT53EzDwL5dHEJGcEbSu.J42', '2020-05-09 15:58:47', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `fk_users_events` (`respo_event`);

--
-- Index pour la table `incomers`
--
ALTER TABLE `incomers`
  ADD PRIMARY KEY (`id`,`id_event`),
  ADD KEY `id_event` (`id_event`);

--
-- Index pour la table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`,`id_projet`),
  ADD KEY `id_projet` (`id_projet`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id_projet`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id_projet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_users_events` FOREIGN KEY (`respo_event`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `incomers`
--
ALTER TABLE `incomers`
  ADD CONSTRAINT `incomers_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incomers_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`id_projet`) REFERENCES `projects` (`id_projet`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
