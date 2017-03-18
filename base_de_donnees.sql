-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Sam 18 Mars 2017 à 21:51
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `facture_prof`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `NumClient` int(11) NOT NULL,
  `NomClient` varchar(255) NOT NULL,
  `PrenomClient` varchar(255) NOT NULL,
  `AdresseClient` varchar(255) NOT NULL,
  `Cp` varchar(255) NOT NULL,
  `VilleClient` varchar(255) NOT NULL,
  `PaysClient` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`NumClient`, `NomClient`, `PrenomClient`, `AdresseClient`, `Cp`, `VilleClient`, `PaysClient`) VALUES
(1, 'Lehmann', 'Nicolas', '12 A rue du sylvaner', '68980', 'Beblenheim', 'France'),
(2, 'Lehmann', 'Martin', '12 A rue du sylvaner', '68980', 'Beblenheim', 'France'),
(3, 'Lehmann', 'Pierre', 'Blabla', '68980', 'Beblenheim', 'France'),
(4, 'Lehmann', 'Sylvain', 'titi', '68980', 'Beblenheim', 'France'),
(9, 'Glas', 'Jean-Michel', '1bis boulevard des Alouettes', '75000', 'Paris', 'France'),
(10, 'Doughnut', 'Bernard', '2 rue du Coquelicot', '65800', 'Pengwenn', 'France'),
(13, 'Bobs', 'Kate', 'impasse du rat Jaune', '99009', 'Big City', 'Big State'),
(14, 'Maison', 'Arthur', 'avenue de l\'HÃ´tel de Ville', '84510', 'Big City', 'Big State'),
(16, 'Dragonneau', 'Newt', '1234 Jump Blv', '98765', 'Dalek Canyon', 'Australie');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`NumClient`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `NumClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
