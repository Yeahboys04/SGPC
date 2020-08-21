-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 05 Juin 2012 à 14:50
-- Version du serveur: 5.1.63-community
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `produits_chimiques`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
  `Id_act` int(3) NOT NULL,
  `Nom_Activite` text NOT NULL,
  PRIMARY KEY (`Id_act`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ajout`
--

CREATE TABLE IF NOT EXISTS `ajout` (
  `ID` int(4) NOT NULL,
  `Id_Produit` int(5) NOT NULL,
  `DATE` date NOT NULL,
  `Quantite` int(5) NOT NULL,
  PRIMARY KEY (`ID`,`Id_Produit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etagere`
--

CREATE TABLE IF NOT EXISTS `etagere` (
  `Etagere` int(4) NOT NULL,
  `Nom_Etagere` text NOT NULL,
  PRIMARY KEY (`Etagere`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE IF NOT EXISTS `etat` (
  `Id_etat` int(2) NOT NULL,
  `Nom_Etat` text NOT NULL,
  PRIMARY KEY (`Id_etat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE IF NOT EXISTS `lieu` (
  `Id_lieu` int(3) NOT NULL,
  `Nom_lieu` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_lieu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE IF NOT EXISTS `produits` (
  `Id_Produit` int(8) NOT NULL,
  `Num_Cas` varchar(20) NOT NULL,
  `Nom_Produit` text NOT NULL,
  `Form_Chimique` varchar(20) DEFAULT NULL,
  `Id_etat` int(2) NOT NULL,
  `Purete` varchar(10) DEFAULT ' ',
  `Phrases_risques` text NOT NULL,
  `Phrases_conseil` text NOT NULL,
  `Symbole` text NOT NULL,
  `Id_lieu` int(3) NOT NULL,
  `Etagere` int(4) DEFAULT NULL,
  `ID` int(4) DEFAULT NULL,
  `Quantite` int(6) NOT NULL,
  `C` varchar(4) DEFAULT NULL,
  `M` varchar(4) DEFAULT NULL,
  `R` varchar(4) DEFAULT NULL,
  `Observations` text,
  `Fournisseur` text,
  PRIMARY KEY (`Id_Produit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `protection_comm`
--

CREATE TABLE IF NOT EXISTS `protection_comm` (
  `Id_protC` int(4) NOT NULL,
  `Nom_Prot` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_protC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `protection_indi`
--

CREATE TABLE IF NOT EXISTS `protection_indi` (
  `ID_ProIn` int(4) NOT NULL,
  `Nom_Pro` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_ProIn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `retrait`
--

CREATE TABLE IF NOT EXISTS `retrait` (
  `ID` int(4) NOT NULL,
  `Id_Produit` int(8) NOT NULL,
  `Date_Retrait` date NOT NULL,
  `Temps_utilisation` int(3) NOT NULL,
  `Id_utilisation` int(3) NOT NULL,
  `Risques` text,
  `Quantite` int(6) NOT NULL,
  `Prot_in` text,
  `Prot_comm` text,
  `Commentaire` text,
  `Id_Retrait` int(10) NOT NULL,
  PRIMARY KEY (`Id_Retrait`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `risques`
--

CREATE TABLE IF NOT EXISTS `risques` (
  `Id_risque` int(3) NOT NULL,
  `Intitule_ris` varchar(30) NOT NULL,
  PRIMARY KEY (`Id_risque`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `ID` int(4) NOT NULL,
  `NOM` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Hach` varchar(60) DEFAULT NULL,
  `Habilitation` varchar(11) DEFAULT NULL,
  `Date_naiss` varchar(10) NOT NULL,
  `Matricule` varchar(10) DEFAULT NULL,
  `Activite` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisations`
--

CREATE TABLE IF NOT EXISTS `utilisations` (
  `Id_utilisation` int(3) NOT NULL,
  `Intitule_uti` varchar(30) NOT NULL,
  PRIMARY KEY (`Id_utilisation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
