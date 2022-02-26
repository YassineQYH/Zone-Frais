-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 26 fév. 2022 à 12:00
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zone-frais`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `firstname`, `lastname`, `company`, `address`, `postal`, `city`, `country`, `phone`) VALUES
(2, 1, 'Maison', 'Yass', 'Qay', NULL, 'rue du test frais', '63000', 'clermont-ferrand', 'FR', '00 11 22 33 44');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `illustration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `illustration`, `description`) VALUES
(1, 'Fruits', 'fruits.jpg', 'Fruits frais'),
(2, 'Légumes', 'legumes.jpg', 'Légumes frais'),
(3, 'Fromages', 'fromages.jpg', 'Fromages frais'),
(4, 'Saucissons', 'saucissons.jpg', 'Saucissons frais');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220125154927', '2022-01-25 16:49:32', 360),
('DoctrineMigrations\\Version20220129191325', '2022-01-29 20:13:30', 39),
('DoctrineMigrations\\Version20220129213312', '2022-01-29 22:38:04', 34),
('DoctrineMigrations\\Version20220129221649', '2022-01-29 23:16:52', 35),
('DoctrineMigrations\\Version20220129225229', '2022-01-29 23:52:33', 36),
('DoctrineMigrations\\Version20220202214708', '2022-02-02 22:47:15', 59);

-- --------------------------------------------------------

--
-- Structure de la table `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `btn_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `illustration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `header`
--

INSERT INTO `header` (`id`, `title`, `content`, `btn_title`, `btn_url`, `illustration`) VALUES
(1, 'Fruits frais', 'Venez découvrir nos fruits frais', 'fruits', '/', 'fruits.jpg'),
(2, 'Légumes', 'Venez découvrir nos légumes frais', 'Légumes', '/', 'legumes.jpg'),
(3, 'Fromages', 'Venez découvrir nos fromages frais', 'Fromages', '/', 'fromages.jpg'),
(4, 'Saucissons', 'Venez découvrir nos saucissons frais', 'Saucissons', '/', 'saucissons.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `illustration`
--

CREATE TABLE `illustration` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `illustration`
--

INSERT INTO `illustration` (`id`, `product_id`, `image`) VALUES
(13, 5, 'pomme01.jpg'),
(14, 5, 'pomme02.jpg'),
(15, 5, 'pomme03.jpg'),
(16, 5, 'pomme04.jpg'),
(17, 6, 'banane01.jpg'),
(18, 6, 'banane02.jpg'),
(19, 6, 'banane03.jpg'),
(20, 7, 'saint-nectaire01.jpg'),
(21, 7, 'saint-nectaire02.jpg'),
(22, 7, 'saint-nectaire03.jpg'),
(23, 8, 'saint-nectaire04.jpg'),
(24, 8, 'saint-nectaire03.jpg'),
(25, 10, 'saucissons.jpg'),
(26, 11, 'fruits-et-legumes.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `delivery` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` int(11) NOT NULL,
  `carrier_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `user_id`, `created_at`, `delivery`, `reference`, `stripe_session_id`, `state`, `carrier_price`) VALUES
(127, 1, '2022-02-02 22:59:39', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fafecb2ef5c', NULL, 0, 6.71),
(128, 1, '2022-02-02 23:00:49', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61faff1136af5', NULL, 0, 6.71),
(129, 1, '2022-02-02 23:02:13', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61faff65d6a76', NULL, 0, 6.71),
(130, 1, '2022-02-02 23:03:00', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61faff9441489', NULL, 0, 6.71),
(131, 1, '2022-02-02 23:03:37', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61faffb93d312', NULL, 0, 6.71),
(132, 1, '2022-02-02 23:04:00', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61faffd017884', NULL, 0, 6.71),
(133, 1, '2022-02-02 23:07:35', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fb00a793540', NULL, 0, 6.71),
(134, 1, '2022-02-02 23:09:36', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fb0120c0d2b', 'cs_test_b1Oahjc24UIN0xQusjMRjeHNIAbAZSxU2fU4pabIEWFSrFTXnD1UK3KGNl', 0, 6.71),
(135, 1, '2022-02-02 23:12:04', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fb01b4d2d1b', NULL, 0, 6.71),
(136, 1, '2022-02-02 23:13:20', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fb0200d2f45', 'cs_test_b1zeVvSvHFBiD8h3fnIOrVKXaznegEyGG24ZvClTs4L098VLYdUnSVqdMB', 0, 6.71),
(137, 1, '2022-02-02 23:16:47', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fb02cf693af', NULL, 0, 6.71),
(138, 1, '2022-02-02 23:16:54', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fb02d614c27', 'cs_test_b1e54iNOyh4TfDSC98OC06yYDTFHr0qyHIt9TlP0haZD1CFrIO7KShVFRO', 0, 6.71),
(139, 1, '2022-02-02 23:17:25', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '02022022-61fb02f55f3a6', 'cs_test_b170nP2T7wovWmgNxJ7Mqtpv02fZDoJKNKi7tSx53kiuq60GaTh66q8rva', 1, 6.71),
(140, 1, '2022-02-03 00:02:56', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '03022022-61fb0da00d14f', NULL, 0, 8.14),
(141, 1, '2022-02-03 00:23:53', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '03022022-61fb1289c0848', NULL, 0, 8.14),
(142, 1, '2022-02-03 00:31:49', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '03022022-61fb14655c97e', 'cs_test_b1XAXeVFnmoV95UMHYQa2G7mbav2UrkhLTDM14Y7CRWcQNxwmUtqXoaLQv', 0, 8.14),
(143, 1, '2022-02-03 00:37:02', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '03022022-61fb159e5139c', 'cs_test_b1JfcBwbhIFXHJhmCFYIXe1e1u2UfxPzvYsVuIs7uWqfFbAV3iWIt8HaWY', 1, 8.14),
(144, 1, '2022-02-03 00:40:24', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '03022022-61fb16687b73c', 'cs_test_b1NzjXOsB5IJPFFMSBGBskEhW5ZYnIQ9YaKHWOqZuQBD1PvZ3upJaFQWAH', 1, 7.5),
(145, 1, '2022-02-03 00:41:58', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '03022022-61fb16c6b1083', 'cs_test_b1CZf4EQosIeaFjH0It5g7xsbode19xOq7GA2ysu14XEKfhX3ZJ50lEfcR', 1, 8.14),
(146, 1, '2022-02-03 15:46:40', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '03022022-61fbead08ae96', NULL, 0, 6.71),
(147, 1, '2022-02-04 12:06:37', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '04022022-61fd08bd64830', 'cs_test_b1pCsR7SliUrcZgFkUYCO4CYVIsW8IsH1OFdBWx9SHal0NHve7yJ24EzfZ', 1, 8.14),
(148, 1, '2022-02-10 01:25:32', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-62045b7c745da', 'cs_test_b1Z9vymRqDjpzK1bqUKhJLVjY8wWZIKaMjrHGdJ0oZOC5H2jbVrmYQXstx', 1, 10.01),
(149, 1, '2022-02-10 02:16:53', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-62046785a1fbe', 'cs_test_b1UkqumTIIIV5rcZTQUvPIKrIuTCfcqOGAd5ISNYqncVIrReVstY4h6B5V', 0, 1180),
(150, 1, '2022-02-10 02:17:13', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620467992e01f', NULL, 0, 11.8),
(151, 1, '2022-02-10 02:17:22', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620467a259e78', NULL, 0, 11.8),
(152, 1, '2022-02-10 02:18:43', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620467f33dcc5', 'cs_test_b1QgcQtkvFADRxmN5uoU6LNzzEGtQvl9UBqhwzKuauxyqUeglM3rJcN7Z3', 0, 11.8),
(153, 1, '2022-02-10 02:19:06', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-6204680a8a9ac', 'cs_test_b1rrFxg06oDHqGlrZiofVi7U3sPT6o9iqumMgHTTdDjEtTyGsm1C5drm7U', 0, 1180),
(154, 1, '2022-02-10 02:19:25', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-6204681dde858', 'cs_test_b1BsDS86LYuyoZCDISFR5TJfOR0KrqHeILCGtIWlu1rtM8XPtcdujFNtr9', 1, 11.8),
(155, 1, '2022-02-10 02:27:10', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620469eee71e8', 'cs_test_b1EC3sHuDXZk5fsAtUP2ewFl6JygsP4HtiKMGN1Hc0c1BC51fFpcWvFkK5', 1, 10.01),
(156, 1, '2022-02-10 03:04:16', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620472a091564', 'cs_test_b1ERJaq9tk69xPNnARsgSp8bTiU1bZBJ6xf0BYjPBUsEhVAt2PsPJYQ4y4', 1, 5.96),
(157, 1, '2022-02-10 03:05:21', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620472e1042c3', 'cs_test_b11FZG7XDCXXARXVXL40gRJZ3DLywFAQxTKfeaKIHQnAUDf1v8WCP8aUzO', 0, 5.96),
(158, 1, '2022-02-10 03:05:41', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620472f59bc1a', 'cs_test_b14G3KH9PfcKpdewqRPrasuMFLdmYUlvxwM7Hh7FRAeVOt2Zp0Q6VA8zSg', 0, 5.96),
(159, 1, '2022-02-10 03:05:58', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-62047306966cb', 'cs_test_b1Lt8yisJPP7GMZntlzqhzk9hNSxsafiuokvgtC1BVH1pMmf1nSjmQyqQO', 0, 596),
(160, 1, '2022-02-10 03:06:16', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-6204731885ecd', 'cs_test_b14xULO0PuDV5dh3x8zgt9cJtyN4Mr3aLeNFWmCD89AG1uJ2h5d3Vb2iFg', 0, 5.96),
(161, 1, '2022-02-10 03:06:43', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-6204733329391', NULL, 0, 5.96),
(162, 1, '2022-02-10 03:06:46', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-6204733631c7e', 'cs_test_b1an0rsWGal3SjwyRjowy5Jl9f7F5tatffEYiMH7K2c4tbuRS47twUKDDX', 0, 5.96),
(163, 1, '2022-02-10 03:07:05', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-62047349d3cd9', NULL, 0, 5.96),
(164, 1, '2022-02-10 03:07:10', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-6204734eeb801', 'cs_test_b1FLGr5UIey27v2j0mS02rqzi8uDJTFwBztqSottyiEdmv7nZv2c8ZGIPM', 0, 5.96),
(165, 1, '2022-02-10 22:25:52', 'Yass Qay</br>00 11 22 33 44</br>rue du test frais</br>63000 clermont-ferrand</br>FR', '10022022-620582e0998b6', 'cs_test_b1bRHh1WXP1fxmrblbq2jxg9fPCHrW7KIDfcIBn8j4wJZ7O9Usig7jCj1L', 3, 8.14);

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `my_order_id` int(11) NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL,
  `weight` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`id`, `my_order_id`, `product`, `quantity`, `price`, `total`, `weight`) VALUES
(130, 127, 'test', 2, 1000, 2000, '0.1'),
(131, 127, 'Pomme', 1, 80, 80, '0.5'),
(132, 128, 'test', 2, 1000, 2000, '0.1'),
(133, 128, 'Pomme', 1, 80, 80, '0.5'),
(134, 129, 'test', 2, 1000, 2000, '0.1'),
(135, 129, 'Pomme', 1, 80, 80, '0.5'),
(136, 130, 'test', 2, 1000, 2000, '0.1'),
(137, 130, 'Pomme', 1, 80, 80, '0.5'),
(138, 131, 'test', 2, 1000, 2000, '0.1'),
(139, 131, 'Pomme', 1, 80, 80, '0.5'),
(140, 132, 'test', 2, 1000, 2000, '0.1'),
(141, 132, 'Pomme', 1, 80, 80, '0.5'),
(142, 133, 'test', 2, 1000, 2000, '0.1'),
(143, 133, 'Pomme', 1, 80, 80, '0.5'),
(144, 134, 'test', 2, 1000, 2000, '0.1'),
(145, 134, 'Pomme', 1, 80, 80, '0.5'),
(146, 135, 'test', 2, 1000, 2000, '0.1'),
(147, 135, 'Pomme', 1, 80, 80, '0.5'),
(148, 136, 'test', 2, 1000, 2000, '0.1'),
(149, 136, 'Pomme', 1, 80, 80, '0.5'),
(150, 137, 'test', 2, 1000, 2000, '0.1'),
(151, 137, 'Pomme', 1, 80, 80, '0.5'),
(152, 138, 'test', 2, 1000, 2000, '0.1'),
(153, 138, 'Pomme', 1, 80, 80, '0.5'),
(154, 139, 'test', 2, 1000, 2000, '0.1'),
(155, 139, 'Pomme', 1, 80, 80, '0.5'),
(156, 140, 'Pomme', 3, 80, 240, '0.5'),
(157, 141, 'Pomme', 3, 80, 240, '0.5'),
(158, 142, 'Pomme', 3, 80, 240, '0.5'),
(159, 142, 'Banane', 1, 50, 50, '0.25'),
(160, 143, 'Pomme', 3, 80, 240, '0.5'),
(161, 143, 'Banane', 1, 50, 50, '0.25'),
(162, 144, 'Pomme', 1, 80, 80, '0.5'),
(163, 144, 'Banane', 1, 50, 50, '0.25'),
(164, 145, 'Pomme', 2, 80, 160, '0.5'),
(165, 145, 'Banane', 1, 50, 50, '0.25'),
(166, 146, 'Pomme', 1, 80, 80, '0.5'),
(167, 147, 'Pomme', 2, 80, 160, '0.5'),
(168, 148, 'Banane', 1, 50, 50, '0.25'),
(169, 148, 'Saint Nectaire entier', 3, 1800, 5400, '1'),
(170, 149, 'Saint Nectaire 500g', 2, 1000, 2000, '0.5'),
(171, 149, 'Saucisson', 2, 450, 900, '2'),
(172, 150, 'Saint Nectaire 500g', 2, 1000, 2000, '0.5'),
(173, 150, 'Saucisson', 2, 450, 900, '2'),
(174, 151, 'Saint Nectaire 500g', 2, 1000, 2000, '0.5'),
(175, 151, 'Saucisson', 2, 450, 900, '2'),
(176, 152, 'Saint Nectaire 500g', 2, 1000, 2000, '0.5'),
(177, 152, 'Saucisson', 2, 450, 900, '2'),
(178, 153, 'Saint Nectaire 500g', 2, 1000, 2000, '0.5'),
(179, 153, 'Saucisson', 2, 450, 900, '2'),
(180, 154, 'Saint Nectaire 500g', 2, 1000, 2000, '0.5'),
(181, 154, 'Saucisson', 2, 450, 900, '2'),
(182, 155, 'Saint Nectaire 500g', 2, 1000, 2000, '0.5'),
(183, 155, 'Saucisson', 1, 450, 450, '2'),
(184, 156, 'Banane', 1, 50, 50, '0.25'),
(185, 157, 'Banane', 1, 50, 50, '0.25'),
(186, 158, 'Banane', 1, 50, 50, '0.25'),
(187, 159, 'Banane', 1, 50, 50, '0.25'),
(188, 160, 'Banane', 1, 50, 50, '0.25'),
(189, 161, 'Banane', 1, 5000, 50, '0.25'),
(190, 162, 'Banane', 1, 5000, 50, '0.25'),
(191, 163, 'Banane', 1, 50, 50, '0.25'),
(192, 164, 'Banane', 1, 50, 50, '0.25'),
(193, 165, 'Banane', 3, 50, 150, '0.25'),
(194, 165, 'Saint Nectaire entier', 1, 1800, 1800, '1');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `is_best` tinyint(1) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `weight_id`, `name`, `slug`, `description`, `image`, `price`, `is_best`, `stock`) VALUES
(5, 1, 2, 'Pomme', 'pomme', 'Pomme Bio', 'pomme01.jpg', 80, 1, 0),
(6, 1, 1, 'Banane', 'banane', 'Banane Bio', 'banane01.jpg', 50, 1, 2),
(7, 3, 4, 'Saint Nectaire entier', 'saint-nectaire-entier', 'Fromage Saint Nectaire entier entre deux', 'saint-nectaire01.jpg', 1800, 1, 5),
(8, 3, 2, 'Saint Nectaire 500g', 'saint-nectaire-500g', 'Demi saint nectaire vieux', 'saint-nectaire04.jpg', 1000, 1, 5),
(10, 4, 5, 'Saucisson', 'saucisson', 'saucisse', 'saucissons.jpg', 450, 1, 7),
(11, 1, 46, 'test', 'test', 'test', 'fruits-et-legumes.jpg', 1000, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reset_password`
--

INSERT INTO `reset_password` (`id`, `user_id`, `token`, `created_at`) VALUES
(1, 3, '61fc21fe52904', '2022-02-03 19:42:06');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `lastname`, `firstname`) VALUES
(1, 'admin@admin.fr', '[\"ROLE_ADMIN\"]', '$2y$13$rQ/cgqEPhtadYdC68nlf.u9bIIA15YtpwTVZFGtOJTgsJXoKlOLNe', 'Qay', 'Yass'),
(3, 'q-destiny@live.be', '', '$2y$13$MfIDQkaVkZNE5e9EmChMRukcfKrsHgs7QwBiBDMLi1QF6e54hOLty', 'Qayouh', 'Yassine'),
(4, 'user@user.fr', '[]', '$2y$13$j.xz9cf3Iwh.nZIbSUdmk.LZDB0MGatBR6OQcwuMz7idasP4bh38W', 'nom', 'prenom'),
(5, 'test@test.fr', '[]', '$2y$13$ObepzjCE9hTRZo.r7rdhPOannRaZ/4shIr5gg638v8q7U3dfgVoOi', 'test', 'test'),
(6, 'test2@test.fr', '[]', '$2y$13$LTW9wyhe3ET9lCR2XfY2ue1ajZQwfvvxEEMcRyVlZ.v5Ooqn1L0aK', 'test', 'test'),
(7, 'test@test2.fr', '[]', '$2y$13$4kfVMUbduyWKAxLyi.6em.qWdedrFxmTHinVtYBLpcofiJR5t8wce', 'test', 'test'),
(8, 'test@test3.fr', '[]', '$2y$13$kfJjVcX6863zymvAYwuqDuXhqSVGJD5F/lcgRo1s4.nCoF6kezYqK', 'test', 'test'),
(9, 'admin2@admin.fr', '[]', '$2y$13$MkijWSsFRNdM6tHm7s.IYe.ZU6..5VBqXJCd4lpi9LfpNWo5TYuFe', 'test', 'test'),
(10, 'test5@test.fr', '[]', '$2y$13$2Z6Z7T2MMcmZtjLyvneSzeM1eBjH3kiQhmyRAAR1ELYf40CG.BqfO', 'test', 'test'),
(11, 'test6@test.fr', '[]', '$2y$13$/ISWuMHH2BA4poRCgqAARObHG8.B4F7LyrrEntUzArlOoecLb6jFG', 'test', 'test'),
(12, 't@t.fr', '[]', '$2y$13$opbdUCCFMTIu9iQMBFZlyu91ZwzpFcyo57YVp8YYMrZO9UOkdbeGm', 'tttt', 'tttt'),
(13, 'rr@rr.fr', '[]', '$2y$13$PK.hoLRvLqAipNiRuVVmA.RWcwMl15OxfIIoxwPyZDAkWfjxjS0qK', 'rr', 'rr'),
(14, 'mail@mail.com', '[]', '$2y$13$Y.ePzHOy0pRJnFdrYHSKEeGiNypsmT/56zaDxyUmHNr6/EN2dPhk2', 'nom', 'pre');

-- --------------------------------------------------------

--
-- Structure de la table `weight`
--

CREATE TABLE `weight` (
  `id` int(11) NOT NULL,
  `kg` double NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `weight`
--

INSERT INTO `weight` (`id`, `kg`, `price`) VALUES
(1, 0.25, 5.96),
(2, 0.5, 6.71),
(3, 0.75, 7.5),
(4, 1, 8.14),
(5, 2, 9.13),
(7, 3, 10.01),
(8, 4, 10.92),
(9, 5, 11.8),
(10, 6, 12.35),
(18, 7, 13.21),
(19, 8, 14.07),
(20, 9, 14.96),
(21, 10, 15.83),
(22, 11, 16.38),
(23, 12, 17.23),
(24, 13, 18.08),
(25, 14, 18.95),
(26, 15, 19.8),
(27, 16, 20.65),
(28, 17, 21.5),
(29, 18, 22.35),
(30, 19, 23.22),
(31, 20, 24.06),
(32, 21, 24.68),
(33, 22, 25.52),
(34, 23, 26.37),
(35, 24, 27.22),
(36, 25, 28.05),
(37, 26, 28.91),
(38, 27, 29.75),
(39, 28, 30.6),
(40, 29, 31.46),
(41, 30, 32.28),
(46, 0.1, 2.65);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4E6F81A76ED395` (`user_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `illustration`
--
ALTER TABLE `illustration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D67B9A424584665A` (`product_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Index pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_845CA2C1BFCDF877` (`my_order_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`),
  ADD KEY `IDX_D34A04AD350035DC` (`weight_id`);

--
-- Index pour la table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B9983CE5A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `weight`
--
ALTER TABLE `weight`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `illustration`
--
ALTER TABLE `illustration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT pour la table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `weight`
--
ALTER TABLE `weight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `illustration`
--
ALTER TABLE `illustration`
  ADD CONSTRAINT `FK_D67B9A424584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `FK_845CA2C1BFCDF877` FOREIGN KEY (`my_order_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD350035DC` FOREIGN KEY (`weight_id`) REFERENCES `weight` (`id`);

--
-- Contraintes pour la table `reset_password`
--
ALTER TABLE `reset_password`
  ADD CONSTRAINT `FK_B9983CE5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
