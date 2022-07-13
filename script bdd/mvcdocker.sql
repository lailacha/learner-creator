-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : dim. 17 avr. 2022 à 21:57
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mvcdocker2`
--

-- --------------------------------------------------------

--
-- Structure de la table `esgi_category_media`
--

CREATE TABLE `esgi_category_media` (
  `id` int(11) NOT NULL,
  `title` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `esgi_course`
--

CREATE TABLE `esgi_course` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `cover` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `esgi_course_category`
--

CREATE TABLE `esgi_course_category` (
  `id` int(11) NOT NULL,
  `name` char(55) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `esgi_file`
--

CREATE TABLE `esgi_file` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `extension` char(11) NOT NULL,
  `category` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `esgi_file_category`
--

CREATE TABLE `esgi_file_category` (
  `id` int(11) NOT NULL,
  `name` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `esgi_lesson`
--

CREATE TABLE `esgi_lesson` (
  `id` int(11) NOT NULL,
  `title` int(11) NOT NULL,
  `text` text NOT NULL,
  `video` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `esgi_receive_password`
--

CREATE TABLE `esgi_receive_password` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `token` char(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `esgi_user`
--

CREATE TABLE `esgi_user` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `firstname` varchar(25) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `token` char(255) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Lesson`
--

CREATE TABLE `Lesson` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `video` int(11) NOT NULL,
  `text` varchar(1500) NOT NULL,
  `user` int(11) NOT NULL,
  `course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `esgi_category_media`
--
ALTER TABLE `esgi_category_media`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `esgi_course`
--
ALTER TABLE `esgi_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categroy-cours` (`category`),
  ADD KEY `creator_course` (`user`),
  ADD KEY `cover` (`cover`);

--
-- Index pour la table `esgi_course_category`
--
ALTER TABLE `esgi_course_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `esgi_file`
--
ALTER TABLE `esgi_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Index pour la table `esgi_file_category`
--
ALTER TABLE `esgi_file_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `esgi_lesson`
--
ALTER TABLE `esgi_lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_course` (`course`),
  ADD KEY `lesson_user` (`user`),
  ADD KEY `lesson_media` (`video`);

--
-- Index pour la table `esgi_receive_password`
--
ALTER TABLE `esgi_receive_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`idUser`);

--
-- Index pour la table `esgi_user`
--
ALTER TABLE `esgi_user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Lesson`
--
ALTER TABLE `Lesson`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `esgi_category_media`
--
ALTER TABLE `esgi_category_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `esgi_course`
--
ALTER TABLE `esgi_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `esgi_course_category`
--
ALTER TABLE `esgi_course_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `esgi_file`
--
ALTER TABLE `esgi_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `esgi_file_category`
--
ALTER TABLE `esgi_file_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `esgi_lesson`
--
ALTER TABLE `esgi_lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `esgi_receive_password`
--
ALTER TABLE `esgi_receive_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `esgi_user`
--
ALTER TABLE `esgi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Lesson`
--
ALTER TABLE `Lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `esgi_course`
--
ALTER TABLE `esgi_course`
  ADD CONSTRAINT `categroy-cours` FOREIGN KEY (`category`) REFERENCES `esgi_course_category` (`id`),
  ADD CONSTRAINT `cover` FOREIGN KEY (`cover`) REFERENCES `esgi_file` (`id`),
  ADD CONSTRAINT `creator_course` FOREIGN KEY (`user`) REFERENCES `esgi_user` (`id`);

--
-- Contraintes pour la table `esgi_file`
--
ALTER TABLE `esgi_file`
  ADD CONSTRAINT `category` FOREIGN KEY (`category`) REFERENCES `esgi_file_category` (`id`);

--
-- Contraintes pour la table `esgi_lesson`
--
ALTER TABLE `esgi_lesson`
  ADD CONSTRAINT `lesson_course` FOREIGN KEY (`course`) REFERENCES `esgi_course` (`id`),
  ADD CONSTRAINT `lesson_media` FOREIGN KEY (`video`) REFERENCES `esgi_file` (`id`),
  ADD CONSTRAINT `lesson_user` FOREIGN KEY (`user`) REFERENCES `esgi_user` (`id`);

--
-- Contraintes pour la table `esgi_receive_password`
--
ALTER TABLE `esgi_receive_password`
  ADD CONSTRAINT `esgi_receive_password_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `esgi_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
