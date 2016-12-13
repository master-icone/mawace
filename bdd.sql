-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 13 Décembre 2016 à 13:14
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `previsionnel`
--

-- --------------------------------------------------------

--
-- Structure de la table `archiveutilisateurs`
--

CREATE TABLE `archiveutilisateurs` (
  `id` int(11) NOT NULL,
  `idDepartement` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idStatut` int(11) NOT NULL,
  `idRole` text NOT NULL,
  `decharge` double NOT NULL,
  `annee` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `archiveutilisateurs`
--

INSERT INTO `archiveutilisateurs` (`id`, `idDepartement`, `idUtilisateur`, `idStatut`, `idRole`, `decharge`, `annee`) VALUES
(1, 1, 1, 1, '2/3/7/8', 0, '2016-2017');

-- --------------------------------------------------------

--
-- Structure de la table `coefficientsnormaux`
--

CREATE TABLE `coefficientsnormaux` (
  `id` int(11) NOT NULL,
  `idTypeCours` int(11) NOT NULL,
  `coeff` double NOT NULL,
  `idStatut` int(11) NOT NULL,
  `annee` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `coefficientsnormaux`
--

INSERT INTO `coefficientsnormaux` (`id`, `idTypeCours`, `coeff`, `idStatut`, `annee`) VALUES
(1, 1, 1.5, 1, '2016-2017'),
(2, 2, 1, 1, '2016-2017'),
(3, 3, 0.66, 1, '2016-2017');

-- --------------------------------------------------------

--
-- Structure de la table `coefficientssupplementaires`
--

CREATE TABLE `coefficientssupplementaires` (
  `id` int(11) NOT NULL,
  `idTypeCours` int(11) NOT NULL,
  `coeff` double NOT NULL,
  `idStatut` int(11) NOT NULL,
  `annee` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `coefficientssupplementaires`
--

INSERT INTO `coefficientssupplementaires` (`id`, `idTypeCours`, `coeff`, `idStatut`, `annee`) VALUES
(1, 1, 1.5, 1, '2016-2017'),
(2, 2, 1, 1, '2016-2017'),
(3, 3, 0.66, 1, '2016-2017');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `idUE` int(11) NOT NULL,
  `idTypeCours` int(11) NOT NULL,
  `annee` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cours`
--

INSERT INTO `cours` (`id`, `idUE`, `idTypeCours`, `annee`) VALUES
(1, 1, 1, '2016-2017'),
(2, 1, 2, '2016-2017'),
(3, 1, 3, '2016-2017');

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `departements`
--

INSERT INTO `departements` (`id`, `nom`) VALUES
(1, 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `heuresaffectees`
--

CREATE TABLE `heuresaffectees` (
  `id` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idCours` int(11) NOT NULL,
  `nbHeures` double NOT NULL,
  `annee` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `heuresaffectees`
--

INSERT INTO `heuresaffectees` (`id`, `idUtilisateur`, `idCours`, `nbHeures`, `annee`) VALUES
(30, 1, 1, 20, '2016-2017'),
(26, 1, 3, 10, '2016-2017');

-- --------------------------------------------------------

--
-- Structure de la table `interdictionaffectation`
--

CREATE TABLE `interdictionaffectation` (
  `id` int(11) NOT NULL,
  `idTypeCours` int(11) NOT NULL,
  `idStatut` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `interdictionaffectation`
--

INSERT INTO `interdictionaffectation` (`id`, `idTypeCours`, `idStatut`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `limitenbcours`
--

CREATE TABLE `limitenbcours` (
  `id` int(11) NOT NULL,
  `idStatut` int(11) NOT NULL,
  `idTypeCours` int(11) NOT NULL,
  `nbHeures` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `limitenbcours`
--

INSERT INTO `limitenbcours` (`id`, `idStatut`, `idTypeCours`, `nbHeures`) VALUES
(1, 1, 3, 10);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `nom`) VALUES
(1, 'Secrétaire'),
(2, 'Résumé des cours'),
(3, 'Voir les tickets'),
(7, 'Envoyer un ticket'),
(8, 'Affectation d\'heures de cours'),
(9, 'Affectation des départements');

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `potentielBrut` double NOT NULL,
  `ordreCours` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `statut`
--

INSERT INTO `statut` (`id`, `nom`, `potentielBrut`, `ordreCours`) VALUES
(1, 'MCF', 192, '');

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `motif` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `idUE` int(11) NOT NULL,
  `date` date NOT NULL,
  `etat` varchar(1) NOT NULL,
  `idExpediteur` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typecours`
--

CREATE TABLE `typecours` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `methodeEnseignement` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `typecours`
--

INSERT INTO `typecours` (`id`, `nom`, `methodeEnseignement`, `description`) VALUES
(1, 'CM', 'normal', 'Cours magistral'),
(2, 'TD', 'normal', 'Travaux dirigés'),
(3, 'TP', 'normal', 'Travaux pratiques');

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

CREATE TABLE `ue` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `idDepartement` int(11) NOT NULL,
  `annee` varchar(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ue`
--

INSERT INTO `ue` (`id`, `nom`, `idDepartement`, `annee`) VALUES
(1, 'Bases de données avancées', 1, '2016-2017');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `nom`, `prenom`) VALUES
(1, 'cdemko', 'DEMKO', 'Christophe');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `archiveutilisateurs`
--
ALTER TABLE `archiveutilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `coefficientsnormaux`
--
ALTER TABLE `coefficientsnormaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `coefficientssupplementaires`
--
ALTER TABLE `coefficientssupplementaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `heuresaffectees`
--
ALTER TABLE `heuresaffectees`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `interdictionaffectation`
--
ALTER TABLE `interdictionaffectation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `limitenbcours`
--
ALTER TABLE `limitenbcours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typecours`
--
ALTER TABLE `typecours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ue`
--
ALTER TABLE `ue`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `archiveutilisateurs`
--
ALTER TABLE `archiveutilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `coefficientsnormaux`
--
ALTER TABLE `coefficientsnormaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `coefficientssupplementaires`
--
ALTER TABLE `coefficientssupplementaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `heuresaffectees`
--
ALTER TABLE `heuresaffectees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `interdictionaffectation`
--
ALTER TABLE `interdictionaffectation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `limitenbcours`
--
ALTER TABLE `limitenbcours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `typecours`
--
ALTER TABLE `typecours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `ue`
--
ALTER TABLE `ue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
